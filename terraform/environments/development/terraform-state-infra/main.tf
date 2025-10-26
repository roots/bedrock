module "tfstate" {
  source                 = "../../../modules/terraform-state"
  project_id             = var.project_id
  location               = var.location
  bucket_name            = var.bucket_name
  create_service_account = var.create_service_account
  sa_account_id          = var.sa_account_id
}
