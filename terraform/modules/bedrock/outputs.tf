output "vm_public_ip" {
  value       = google_compute_address.bedrock_ip.address
  description = "Static external IP for the VM."
}

output "ssh_user" {
  value       = var.ssh_user
  description = "SSH username to use."
}

output "deploy_path" {
  value       = var.deploy_path
  description = "Target deploy path used by CI (releases/current)."
}

output "healthcheck_url" {
  value       = "http://${google_compute_address.bedrock_ip.address}/"
  description = "HTTP URL (IP-based) for CI health check."
}
