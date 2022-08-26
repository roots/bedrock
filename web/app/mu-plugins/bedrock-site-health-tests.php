<?php

/**
 * Plugin Name:  Bedrock Site Health Tests
 * Plugin URI:   https://roots.io/bedrock/
 * Description:  Customizes status tests that conflict with the way Bedrock is structured.
 * Version:      1.0.0
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
 */

namespace Roots\Bedrock;

use WP_HTTP_Response;

add_filter( 'site_status_test_result', function ( array $result ) : array {
    if ( ! isset( $result['test'] ) || $result['test'] !== 'background_updates' ) {
        return $result;
    }

    return override_test_background_updates( $result );
} );

add_filter( 'rest_post_dispatch', function ( WP_HTTP_Response $result ) : WP_HTTP_Response {
    $data = $result->get_data();
    if ( ! isset( $data['test'] ) || $data['test'] !== 'background_updates' ) {
        return $result;
    }

    $result->set_data( override_test_background_updates( $data ) );
    return $result;
} );

/**
 * Overrides the result of the finished Background updates test
 * to avoid conflict with the way Bedrock is structured
 * (managed by Composer and version control system).
 */
function override_test_background_updates( array $result ) : array
{
    return array_replace( $result, [
        'label'       => __( 'Background updates are disabled by Bedrock' ),
        'status'      => 'good',
        'description' => sprintf(
            '<p>%s</p><blockquote class="notice notice-info">%s</blockquote>',
            __( 'This site is under version control. Updates are managed by Composer.' ),
            $result['description']
        ),
    ] );
}
