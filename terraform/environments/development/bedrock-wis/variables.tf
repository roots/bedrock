variable "project_id"            { type = string }
variable "region"                { type = string }   # e.g. "europe-north1"
variable "zone"                  { type = string }   # e.g. "europe-north1-a"

variable "project_prefix"        { type = string }   # e.g. "bedrock-wis"
variable "instance_type"         { type = string }   # e.g. "e2-medium"
variable "network_self_link"     { type = string }
variable "subnet_self_link"      { type = string }
variable "service_account_email" { type = string }

# Local file paths (env reads files, module receives contents)
variable "ssh_public_key_path" { type = string }

# Optional override
variable "ssh_user" {
  type    = string
  default = "jure"
}

variable "deploy_path" {
  type    = string
  default = "/var/www/bedrock"
}

variable "db_name" {
  type = string
  default = "bedrock"
}

variable "db_user" {
  type = string
  default = "bedrock"
}

variable "db_pass" {
  type = string
  default = "bedrockpwd"
}
