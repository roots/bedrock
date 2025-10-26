terraform {
  backend "gcs" {
    bucket = "vertical-ratio-476314-v0-tfstate-eun1"
    prefix = "bedrock-wis/development"
  }
}
