#!/bin/bash
set -euxo pipefail

# -------- Settings you can keep as-is --------
SSH_USER="jure"
DEPLOY_PATH="/var/www/bedrock"

# -------- Metadata helpers --------
META="http://metadata.google.internal/computeMetadata/v1"
HDR="Metadata-Flavor: Google"

get_attr() { curl -fsS -H "$HDR" "$META/instance/attributes/$1" || true; }
get_ext_ip() { curl -fsS -H "$HDR" "$META/instance/network-interfaces/0/access-configs/0/external-ip" || true; }

# -------- Inputs from metadata (with sane defaults) --------
DB_NAME="$(get_attr db_name)";      DB_NAME="${DB_NAME:-bedrock}"
DB_USER="$(get_attr db_user)";      DB_USER="${DB_USER:-bedrock}"
DB_PASS="$(get_attr db_pass)";      DB_PASS="${DB_PASS:-bedrockpwd}"
WP_ENV="$(get_attr wp_env)";        WP_ENV="${WP_ENV:-development}"
WP_HOME_META="$(get_attr wp_home)"; # optional override

# Compute VM_IP and default WP_HOME if not provided
VM_IP="$(get_ext_ip)"
if [ -z "${WP_HOME_META}" ]; then
  if [ -n "${VM_IP}" ]; then
    WP_HOME="http://${VM_IP}"
  else
    WP_HOME="http://127.0.0.1"
  fi
else
  WP_HOME="${WP_HOME_META}"
fi

# ----------------------------
# 0) SSHD hardening (key-only)
# ----------------------------
if grep -qE '^[# ]*PasswordAuthentication' /etc/ssh/sshd_config; then
  sed -i 's/^[# ]*PasswordAuthentication .*/PasswordAuthentication no/' /etc/ssh/sshd_config
else
  echo 'PasswordAuthentication no' >> /etc/ssh/sshd_config
fi
if grep -qE '^[# ]*PermitRootLogin' /etc/ssh/sshd_config; then
  sed -i 's/^[# ]*PermitRootLogin .*/PermitRootLogin no/' /etc/ssh/sshd_config
else
  echo 'PermitRootLogin no' >> /etc/ssh/sshd_config
fi
if grep -qE '^[# ]*PubkeyAuthentication' /etc/ssh/sshd_config; then
  sed -i 's/^[# ]*PubkeyAuthentication .*/PubkeyAuthentication yes/' /etc/ssh/sshd_config
else
  echo 'PubkeyAuthentication yes' >> /etc/ssh/sshd_config
fi
systemctl reload ssh || systemctl reload sshd || true

# ----------------------------
# 1) Base packages (Debian/Ubuntu)
# ----------------------------
export DEBIAN_FRONTEND=noninteractive
apt-get update -y
apt-get install -y \
  apache2 libapache2-mod-php php php-cli php-mysql php-curl php-xml php-mbstring php-zip php-intl php-gd \
  mariadb-server mariadb-client acl unzip curl

# ----------------------------
# 2) Deploy path & permissions
# ----------------------------
mkdir -p "${DEPLOY_PATH}/releases" "${DEPLOY_PATH}/shared/uploads"
chown -R "${SSH_USER}":"${SSH_USER}" "${DEPLOY_PATH}"
# Allow www-data to traverse shared paths
chgrp -R www-data "${DEPLOY_PATH}" || true
setfacl -R -m u:www-data:rx "${DEPLOY_PATH}" || true

# If .env exists, just ensure perms (don’t overwrite)
if [ -f "${DEPLOY_PATH}/shared/.env" ]; then
  chown "${SSH_USER}":www-data "${DEPLOY_PATH}/shared/.env" || true
  chmod 0640 "${DEPLOY_PATH}/shared/.env" || true
fi

# ----------------------------
# 3) Apache vhost -> current/web
# ----------------------------
cat >/etc/apache2/sites-available/bedrock.conf <<APACHE
<VirtualHost *:80>
  ServerName ${VM_IP}
  DocumentRoot ${DEPLOY_PATH}/current/web

  <Directory ${DEPLOY_PATH}/current/web>
    AllowOverride All
    Require all granted
  </Directory>

  ErrorLog \${APACHE_LOG_DIR}/bedrock_error.log
  CustomLog \${APACHE_LOG_DIR}/bedrock_access.log combined
</VirtualHost>
APACHE

a2enmod rewrite || true
a2dissite 000-default || true
a2ensite bedrock || true
systemctl enable apache2 --now
systemctl reload apache2 || true

# ----------------------------
# 4) MariaDB: ensure DB/user exist and password is correct
# ----------------------------
systemctl enable mariadb --now

mariadb <<SQL || true
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
ALTER USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

mariadb <<SQL || true
CREATE USER IF NOT EXISTS '${DB_USER}'@'127.0.0.1' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'127.0.0.1';
FLUSH PRIVILEGES;
SQL

# ----------------------------
# 5) Create .env once (idempotent)
# ----------------------------
ENV_FILE="${DEPLOY_PATH}/shared/.env"
if [ ! -f "${ENV_FILE}" ]; then
  cat > "${ENV_FILE}" <<ENV
WP_ENV=${WP_ENV}
WP_HOME=${WP_HOME}
WP_SITEURL=\${WP_HOME}/wp

DB_NAME=${DB_NAME}
DB_USER=${DB_USER}
DB_PASSWORD=${DB_PASS}
DB_HOST=127.0.0.1
DB_CHARSET=utf8mb4
DB_COLLATE=
ENV

  # Add fresh salts
  curl -fsS https://api.wordpress.org/secret-key/1.1/salt/ >> "${ENV_FILE}"
  chown ${SSH_USER}:www-data "${ENV_FILE}"
  chmod 0640 "${ENV_FILE}"
  setfacl -m u:www-data:rx "${DEPLOY_PATH}" "${DEPLOY_PATH}/shared" || true
fi

# ----------------------------
# 6) Placeholder until CI deploys
# ----------------------------
mkdir -p "${DEPLOY_PATH}/current/web"
if [ ! -f "${DEPLOY_PATH}/current/web/index.html" ] && [ ! -f "${DEPLOY_PATH}/current/web/index.php" ]; then
  echo "bedrock placeholder (CI deploy will replace this)" > "${DEPLOY_PATH}/current/web/index.html"
fi

chown -R "${SSH_USER}":www-data "${DEPLOY_PATH}"
chmod -R g+rx "${DEPLOY_PATH}"
systemctl reload apache2 || true
