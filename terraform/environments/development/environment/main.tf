module "infra" {
  source         = "../../../modules/environment"
  project_id     = var.project_id
  region         = var.region
  project_prefix = var.project_prefix
}
