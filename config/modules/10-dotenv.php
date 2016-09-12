<?php
/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv(BEDROCK_ROOT_DIR);
if (file_exists(BEDROCK_ROOT_DIR . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}
