<?php

namespace TypeIt;

define("TYPEIT_TRANSIENT_EXPIRATION", 43200); // 12 hours
define("TYPEIT_UPDATE_CHECK_TRANSIENT", "wp_update_check_wp_typeit");
define("TYPEIT_UPDATE_ENDPOINT", "https://wp-plugin-update.vercel.app/api/wp-typeit");

add_filter('site_transient_update_plugins', '\TypeIt\push_update');
add_filter('transient_update_plugins', '\TypeIt\push_update');
add_filter('plugin_row_meta', '\TypeIt\remove_view_details_link', 10, 4);
add_filter('self_admin_url', '\TypeIt\modify_version_details_url', 10, 3);

function modify_version_details_url($url, $path, $scheme)
{
    if (strpos($url, "plugin=wp-typeit") !== false) {
        return "https://typeitjs.com/docs/wordpress#changelog";
    }

    return $url;
}

function remove_view_details_link($pluginMeta, $pluginFile, $remoteData, $status)
{
    if ($remoteData['slug'] === 'wp-typeit') {
        unset($pluginMeta[2]);
    }

    return $pluginMeta;
}

/**
 * Retrieve the latest plugin version information from endpoint.
 *
 * @return object
 */
function fetch_remote_data()
{
    $remoteData = wp_remote_get(
        TYPEIT_UPDATE_ENDPOINT,
        [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]
    );

    // Something went wrong!
    if (
        is_wp_error($remoteData) ||
        wp_remote_retrieve_response_code($remoteData) !== 200
    ) {
        return null;
    }

    $remoteData = json_decode($remoteData['body']);

    // Should resemble object described here:
    // https://make.wordpress.org/core/2020/07/30/recommended-usage-of-the-updates-api-to-support-the-auto-updates-ui-for-plugins-and-themes-in-wordpress-5-5/
    return (object) [
        'id'            => 'wp-typeit/typeit.php',
        'slug'          => 'wp-typeit',
        'plugin'        => 'wp-typeit/typeit.php',
        'new_version'   => $remoteData->version,
        'url'           => 'https://typeitjs.com',
        'package'       => $remoteData->package,
        'icons'         => [],
        'banners'       => [],
        'banners_rtl'   => [],
        'tested'        => '',
        'requires_php'  => '7.2',
        'compatibility' => new \stdClass(),
    ];
}

function push_update($updatePluginsTransient)
{
    $checkPluginTransient = get_transient(TYPEIT_UPDATE_CHECK_TRANSIENT);

    $pluginData = $checkPluginTransient ?: fetch_remote_data();

    if (!$pluginData) {
        return $updatePluginsTransient;
    }

    if (!$checkPluginTransient) {
        set_transient(
            TYPEIT_UPDATE_CHECK_TRANSIENT,
            $pluginData,
            TYPEIT_TRANSIENT_EXPIRATION
        );
    }

    if (version_compare($pluginData->new_version, WP_TYPEIT_PLUGIN_VERSION, ">")) {
        $updatePluginsTransient->response['wp-typeit/typeit.php'] = $pluginData;
        unset($updatePluginsTransient->no_update['wp-typeit/typeit.php']);
    } else {
        $updatePluginsTransient->no_update['wp-typeit/typeit.php'] = $pluginData;
        unset($updatePluginsTransient->response['wp-typeit/typeit.php']);
    }

    return $updatePluginsTransient;
}
