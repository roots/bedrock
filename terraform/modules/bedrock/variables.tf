variable "project_prefix"        { type = string }
variable "instance_type"         { type = string }
variable "region"                { type = string }
variable "zone"                  { type = string }
variable "network_self_link"     { type = string }
variable "subnet_self_link"      { type = string }
variable "service_account_email" { type = string }

# SSH & deploy settings
variable "ssh_user" {
  type    = string
  default = "jure"
}
# Pass the **content** of the public key (use file() in the environment)
variable "ssh_public_key" { type = string }

variable "deploy_path" {
  type    = string
  default = "/var/www/bedrock"
}

# Bring the startup script **content** from the environment via file()
variable "startup_script" {
  type = string
}

# Who can reach 80/443 (web). Default: anywhere
variable "web_source_ranges" {
  type    = list(string)
  default = ["0.0.0.0/0"]
}

# Who can SSH (22). Default: anywhere — RECOMMEND overriding to your IP/32
variable "ssh_source_ranges" {
  type    = list(string)
  default = ["0.0.0.0/0"]
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

