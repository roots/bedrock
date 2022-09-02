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

add_filter( 'site_status_test_result', __NAMESPACE__ . '\\filter_site_status_test_result' );
add_filter( 'rest_post_dispatch', __NAMESPACE__ . '\\filter_rest_post_dispatch' );

/**
 * Filters the output for the Background updates test
 * to override the result.
 *
 * @param  array<array-key, mixed> $result An associative array of test result data.
 * @return array<array-key, mixed>
 */
function filter_site_status_test_result( array $result ) : array {
    if (
        ! isset( $result['test'] ) ||
        $result['test'] !== 'background_updates'
    ) {
        return $result;
    }

    return override_test_background_updates( $result );
}

/**
 * Filters the REST API response for the Background updates test
 * to override the result.
 *
 * @param  WP_HTTP_Response $result The REST API response.
 * @return WP_HTTP_Response
 */
function filter_rest_post_dispatch( WP_HTTP_Response $result ) : WP_HTTP_Response {
    $data = $result->get_data();
    if (
        ! is_array( $data ) ||
        ! isset( $data['test'] ) ||
        $data['test'] !== 'background_updates'
    ) {
        return $result;
    }

    /** @var array<array-key, mixed> $data */

    $result->set_data( override_test_background_updates( $data ) );
    return $result;
}

/**
 * Overrides the result of the finished Background updates test
 * to avoid conflict with the way Bedrock is structured
 * (managed by Composer and version control system).
 *
 * @param  array<array-key, mixed> $result An associative array of test result data.
 * @return array<array-key, mixed>
 */
function override_test_background_updates( array $result ) : array {
    $description = sprintf(
        '<p>%s</p>',
        __( 'This site is under version control. Updates are managed by Composer.' )
    );

    if (
        isset( $result['description'] ) &&
        is_string( $result['description'] )
    ) {
        $description .= sprintf(
            '<blockquote class="notice notice-info">%s</blockquote>',
            $result['description']
        );
    }

    return array_replace( $result, [
        'label'       => __( 'Background updates are disabled by Bedrock' ),
        'status'      => 'good',
        'description' => $description,
    ] );
}
