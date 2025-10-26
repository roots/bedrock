output "vm_public_ip" {
  value       = module.bedrock.vm_public_ip
  description = "Static external IP for SSH and health checks."
}

output "ssh_user" {
  value       = module.bedrock.ssh_user
  description = "SSH username."
}

output "deploy_path" {
  value       = module.bedrock.deploy_path
  description = "Target deploy path used by CI (releases/current)."
}

output "healthcheck_url" {
  value       = module.bedrock.healthcheck_url
  description = "HTTP URL (IP-based) for CI health check."
}
