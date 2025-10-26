#!/bin/bash
set -euxo pipefail

SSH_USER="jure"
DEPLOY_PATH="/var/www/bedrock"
VM_IP="34.88.159.90"

# --- read DB config from instance metadata (fallbacks OK for dev) ---
META="http://metadata.google.internal/computeMetadata/v1/instance/attributes"
HDR="Metadata-Flavor: Google"
DB_NAME="$(curl -fsS -H "$HDR" "$META/db_name" || echo 'bedrock')"
DB_USER="$(curl -fsS -H "$HDR" "$META/db_user" || echo 'bedrock')"
DB_PASS="$(curl -fsS -H "$HDR" "$META/db_pass" || echo 'bedrockpwd')"

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
# 1) Base packages (Debian 12 / MariaDB)
# ----------------------------
apt-get update -y
DEBIAN_FRONTEND=noninteractive apt-get install -y \
  apache2 libapache2-mod-php php php-mysql php-cli php-curl php-xml php-mbstring unzip \
  mariadb-server mariadb-client acl curl

# ----------------------------
# 2) Deploy path & permissions
# ----------------------------
install -o "${SSH_USER}" -g "${SSH_USER}" -d "${DEPLOY_PATH}/shared/uploads"

# If .env exists, fix ownership/permissions; don't overwrite
if [ -f "${DEPLOY_PATH}/shared/.env" ]; then
  chown "${SSH_USER}":www-data "${DEPLOY_PATH}/shared/.env" || true
  chmod 0640 "${DEPLOY_PATH}/shared/.env" || true
fi

# www-data must be able to traverse into shared
chgrp -R www-data "${DEPLOY_PATH}" || true
setfacl -R -m u:www-data:rx "${DEPLOY_PATH}" || true

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
# 5) Create /var/www/bedrock/shared/.env once (if missing)
# ----------------------------
ENV_FILE="${DEPLOY_PATH}/shared/.env"
if [ ! -f "${ENV_FILE}" ]; then
  cat > "${ENV_FILE}" <<ENV
WP_ENV=development
WP_HOME=http://${VM_IP}
WP_SITEURL=\${WP_HOME}/wp

DB_NAME=${DB_NAME}
DB_USER=${DB_USER}
DB_PASSWORD=${DB_PASS}
DB_HOST=127.0.0.1
DB_CHARSET=utf8mb4
DB_COLLATE=
ENV
  # add fresh salts
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
