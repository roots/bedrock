<?php

/**
 * Plugin Name:  Bedrock Composer Store
 * Description:  Adds a button to the plugin install screen to add plugins to composer.json.
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
 */

namespace Roots\Bedrock;

if (!defined('ABSPATH') && !defined('WP_ENV') && !in_array(WP_ENV, ['development', 'staging'])) exit;

class BedrockComposerStore
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_bedrock_composer_install', [$this, 'handle_composer_install']);
        add_action('wp_ajax_bedrock_check_composer', [$this, 'check_composer_status']);
        add_action('admin_footer-plugin-install.php', [$this, 'inject_ui']);
    }

    public function enqueue_scripts($hook)
    {
        if ($hook !== 'plugin-install.php') return;
        wp_localize_script('jquery', 'bedrock_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bedrock_composer_nonce'),
            'add_text' => 'Add to Composer',
            'adding_text' => 'Adding...',
            'added_text' => 'Already in Composer'
        ]);
    }

    public function inject_ui()
    {
?>
        <style>
            .bedrock-btn {
                background: #2271b1 !important;
                color: #fff !important;
                margin-top: 5px !important;
            }

            .bedrock-btn:hover,
            .bedrock-btn:focus {
                background: #135e96 !important;
                border-color: #135e96 !important;
                color: #fff !important
            }

            .bedrock-btn:disabled {
                background: #646970 !important;
                border-color: #646970 !important;
                color: #fff !important;
                cursor: not-allowed;
            }
        </style>
        <script>
            jQuery(function($) {
                function addComposerButtons() {
                    const plugins = [];
                    $('.plugin-card').each(function() {
                        const $card = $(this),
                            $install = $card.find('.install-now');
                        if (!$install.length || $card.find('.bedrock-btn').length) return;
                        const slug = $install.data('slug'),
                            name = $card.find('.name').text().trim();
                        if (!slug || !name) return;
                        plugins.push({
                            slug,
                            name,
                            card: $card,
                            install: $install
                        });
                    });

                    if (plugins.length === 0) return;

                    $.ajax({
                        url: bedrock_ajax.ajax_url,
                        method: 'POST',
                        data: {
                            action: 'bedrock_check_composer',
                            plugin_slugs: plugins.map(p => p.slug),
                            nonce: bedrock_ajax.nonce
                        },
                        success: function(r) {
                            plugins.forEach(plugin => {
                                const exists = r.data.existing_plugins.includes(plugin.slug);
                                if (exists) {
                                    plugin.install.after($('<button>', {
                                        class: 'button bedrock-btn disabled',
                                        text: bedrock_ajax.added_text,
                                        disabled: true
                                    }));
                                } else {
                                    plugin.install.after($('<button>', {
                                        class: 'button bedrock-btn',
                                        text: bedrock_ajax.add_text,
                                        'data-slug': plugin.slug,
                                        'data-name': plugin.name
                                    }));
                                }
                            });
                        }
                    });
                }

                addComposerButtons();

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.addedNodes.length > 0) {
                            $(mutation.addedNodes).find('.plugin-card').each(function() {
                                if (!$(this).find('.bedrock-btn').length) {
                                    setTimeout(addComposerButtons, 100);
                                    return false;
                                }
                            });
                        }
                    });
                });

                observer.observe(document.querySelector('#plugin-filter'), {
                    childList: true,
                    subtree: true
                });

                $(document).on('click', '.bedrock-btn:not(.disabled)', function(e) {
                    e.preventDefault();
                    const $btn = $(this),
                        slug = $btn.data('slug'),
                        name = $btn.data('name');
                    if ($btn.prop('disabled')) return;
                    $btn.prop('disabled', true).text(bedrock_ajax.adding_text);
                    $.ajax({
                        url: bedrock_ajax.ajax_url,
                        method: 'POST',
                        data: {
                            action: 'bedrock_composer_install',
                            plugin_slug: slug,
                            plugin_name: name,
                            nonce: bedrock_ajax.nonce
                        },
                        success: function(r) {
                            if (r.success) {
                                $btn.addClass('disabled').text(bedrock_ajax.added_text);
                                $('<div class="notice notice-success is-dismissible"><p>' + r.data.message + '</p></div>').insertAfter('.wp-header-end');
                            } else {
                                $btn.prop('disabled', false).text(bedrock_ajax.add_text);
                                alert('Error: ' + r.data.message);
                            }
                        },
                        error: () => {
                            $btn.prop('disabled', false).text(bedrock_ajax.add_text);
                            alert('Installation failed');
                        }
                    });
                });
            });
        </script>
<?php
    }

    public function check_composer_status()
    {
        if (!check_ajax_referer('bedrock_composer_nonce', 'nonce', false) || !current_user_can('install_plugins')) {
            wp_send_json_error(['message' => 'Permission denied']);
        }

        $slugs = isset($_POST['plugin_slugs']) ? (array) $_POST['plugin_slugs'] : [sanitize_text_field($_POST['plugin_slug'] ?? '')];
        $composer_path = realpath(ABSPATH . '../../') . '/composer.json';

        if (!file_exists($composer_path)) {
            wp_send_json_success(['existing_plugins' => []]);
            return;
        }

        $composer_data = json_decode(file_get_contents($composer_path), true);
        $existing_plugins = [];

        foreach ($slugs as $slug) {
            $slug = sanitize_text_field($slug);
            $package = "wpackagist-plugin/{$slug}";
            if (isset($composer_data['require'][$package])) {
                $existing_plugins[] = $slug;
            }
        }

        wp_send_json_success(['existing_plugins' => $existing_plugins]);
    }

    public function handle_composer_install()
    {
        if (!check_ajax_referer('bedrock_composer_nonce', 'nonce', false) || !current_user_can('install_plugins')) {
            wp_send_json_error(['message' => 'Permission denied']);
        }

        $slug = sanitize_text_field($_POST['plugin_slug']);
        $name = sanitize_text_field($_POST['plugin_name']);

        try {
            $composer_path = realpath(ABSPATH . '../../') . '/composer.json';
            $composer_data = json_decode(file_get_contents($composer_path), true);
            $package = "wpackagist-plugin/{$slug}";

            if (isset($composer_data['require'][$package])) {
                wp_send_json_error(['message' => 'Plugin already in composer.json']);
            }

            $version = $this->get_plugin_version($slug);
            $composer_data['require'][$package] = "^{$version}";
            ksort($composer_data['require']);
            file_put_contents($composer_path, json_encode($composer_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            wp_send_json_success(['message' => "Plugin '{$name}' v{$version} added to composer.json!"]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    private function get_plugin_version($slug)
    {
        $api_url = "https://api.wordpress.org/plugins/info/1.0/{$slug}.json";
        $response = wp_remote_get($api_url);

        if (is_wp_error($response)) {
            return '1.0';
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data['version'])) {
            return $data['version'];
        }

        return '1.0';
    }
}

new BedrockComposerStore();
