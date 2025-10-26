variable "project_id" {
  type = string
}

variable "region" {
  type    = string
  default = "europe-north1"
}

variable "location" {
  type    = string
  default = "EUROPE-NORTH1" # bucket location (uppercase API code)
}

variable "bucket_name" {
  type        = string
  description = "Globally unique bucket name for TF state"
}
variable "create_service_account" {
  type    = bool
  default = true
}
variable "sa_account_id" {
  type    = string
  default = "terraform-state-ci"
}
