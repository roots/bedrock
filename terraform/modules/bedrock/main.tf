terraform {
  required_providers {
    google = {
      source  = "hashicorp/google"
      version = ">= 5.0"
    }
  }
  required_version = ">= 1.5.0"
}

# Static external IP
resource "google_compute_address" "bedrock_ip" {
  name   = "${var.project_prefix}-ip"
  region = var.region
}

# Allow HTTP/HTTPS to the VM
resource "google_compute_firewall" "bedrock_allow_web" {
  name    = "${var.project_prefix}-allow-web"
  network = var.network_self_link

  allow {
    protocol = "tcp"
    ports    = ["80", "443"]
  }

  source_ranges = var.web_source_ranges
  target_tags   = ["wordpress", "bedrock"]
}

# Allow SSH to the VM
resource "google_compute_firewall" "bedrock_allow_ssh" {
  name    = "${var.project_prefix}-allow-ssh"
  network = var.network_self_link

  allow {
    protocol = "tcp"
    ports    = ["22"]
  }

  source_ranges = var.ssh_source_ranges
  target_tags   = ["wordpress", "bedrock"]
}


# VM instance
resource "google_compute_instance" "wordpress_vm" {
  name         = "${var.project_prefix}-vm"
  machine_type = var.instance_type
  zone         = var.zone

  boot_disk {
    initialize_params {
      image = "debian-cloud/debian-12"
      size  = 20
    }
  }

  network_interface {
    network    = var.network_self_link
    subnetwork = var.subnet_self_link

    access_config {
      # pin the reserved static IP
      nat_ip = google_compute_address.bedrock_ip.address
    }
  }

  # Put SSH public key for the chosen user into instance metadata
  metadata = {
    ssh-keys       = "${var.ssh_user}:${trimspace(var.ssh_public_key)}"
    db_name        = var.db_name
    db_user        = var.db_user
    db_pass        = var.db_pass
  }

  # Use the startup script content coming from the environment
  metadata_startup_script = var.startup_script

  service_account {
    email  = var.service_account_email
    scopes = ["https://www.googleapis.com/auth/cloud-platform"]
  }

  allow_stopping_for_update = true

  tags = ["wordpress", "bedrock"]

  depends_on = [
    google_compute_firewall.bedrock_allow_web,
    google_compute_firewall.bedrock_allow_ssh
  ]
}
