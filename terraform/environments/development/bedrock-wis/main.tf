data "terraform_remote_state" "infra" {
  backend = "gcs"
  config = {
    bucket = "vertical-ratio-476314-v0-tfstate-eun1"
    prefix = "environment/development"
  }
}

module "bedrock" {
  source = "../../../modules/bedrock"

  project_prefix        = var.project_prefix
  instance_type         = var.instance_type
  region                = var.region
  zone                  = var.zone

  # ✅ pass the correct arg names the module expects
  network_self_link     = data.terraform_remote_state.infra.outputs.network_self_link
  subnet_self_link      = data.terraform_remote_state.infra.outputs.subnet_self_link

  service_account_email = var.service_account_email

  ssh_user        = var.ssh_user
  ssh_public_key  = file(var.ssh_public_key_path)
  deploy_path     = var.deploy_path
  startup_script  = file("${path.module}/startup_script.sh")

  # (optional) restrict sources
  web_source_ranges = ["0.0.0.0/0"]
  # ssh_source_ranges = ["MY.IP.ADDR/32"]

  db_name = var.db_name
  db_user = var.db_user
  db_pass = var.db_pass
}


