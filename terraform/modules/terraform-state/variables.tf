variable "project_id" { type = string }
variable "location"   { type = string }

variable "bucket_name" {
  type        = string
  description = "Globally unique GCS bucket name for TF state"
}

variable "create_service_account" {
  type    = bool
  default = true
}

variable "sa_account_id" {
  type        = string
  default     = "terraform-state-ci"
  description = "Service account ID (without domain) if create_service_account=true"
}
