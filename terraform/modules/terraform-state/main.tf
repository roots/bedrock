resource "google_storage_bucket" "tfstate" {
  name                        = var.bucket_name
  project                     = var.project_id
  location                    = var.location
  force_destroy               = false
  uniform_bucket_level_access = true

  versioning { enabled = true }

  lifecycle_rule {
    action { type = "Delete" }
    condition { num_newer_versions = 50 }
  }
}

# Optional SA for CI/CD to use with this bucket (least privilege)
resource "google_service_account" "tfstate_sa" {
  count        = var.create_service_account ? 1 : 0
  project      = var.project_id
  account_id   = var.sa_account_id
  display_name = "Terraform State CI Service Account"
}

# Bucket-level perm for the SA to read/write state objects
resource "google_storage_bucket_iam_member" "sa_object_admin" {
  count  = var.create_service_account ? 1 : 0
  bucket = google_storage_bucket.tfstate.name
  role   = "roles/storage.objectAdmin"
  member = "serviceAccount:${google_service_account.tfstate_sa[0].email}"
}

# (Optional) allow SA to read bucket metadata (not required for state writes)
resource "google_storage_bucket_iam_member" "sa_viewer" {
  count  = var.create_service_account ? 1 : 0
  bucket = google_storage_bucket.tfstate.name
  role   = "roles/storage.legacyBucketReader"
  member = "serviceAccount:${google_service_account.tfstate_sa[0].email}"
}

output "bucket_name" {
  value = google_storage_bucket.tfstate.name
}

output "bucket_url" {
  value = "gs://${google_storage_bucket.tfstate.name}"
}

output "service_account_email" {
  value       = try(google_service_account.tfstate_sa[0].email, null)
  description = "Email of the optional SA (if created)"
}
