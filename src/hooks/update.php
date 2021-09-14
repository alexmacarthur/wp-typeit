<?php

namespace TypeIt;

add_filter('site_transient_update_plugins', '\TypeIt\push_update');
add_filter('transient_update_plugins', '\TypeIt\push_update');
add_filter('plugin_row_meta', '\TypeIt\remove_view_details_link', 10, 4);
add_filter('self_admin_url', '\TypeIt\modify_version_details_url', 10, 3);

define("TYPEIT_TRANSIENT_EXPIRATION", 43200); // 12 hours
define("TYPEIT_UPDATE_CHECK_TRANSIENT", "wp_update_check_wp_typeit");
define("TYPEIT_UPDATE_ENDPOINT", "https://wp-plugin-update.now.sh/api/plugin/wp-typeit");

function modify_version_details_url($url, $path, $scheme)
{
    if (strpos($url, "plugin=wp-typeit") !== false) {
        return "https://typeitjs.com/docs/wordpress#changelog";
    }

    return $url;
}

function remove_view_details_link($pluginMeta, $pluginFile, $pluginData, $status)
{
    if ($pluginData['slug'] === 'wp-typeit') {
        unset($pluginMeta[2]);
    }

    return $pluginMeta;
}

/**
 * Fetch plugin data from remote endpoint.
 *
 * @return object
 */
function fetch_remote_data()
{
    $pluginData = wp_remote_get(
        TYPEIT_UPDATE_ENDPOINT,
        [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]
    );

    // Something went wrong!
    if (
        is_wp_error($pluginData) ||
        ($pluginData['response']['code'] ?? null) !== 200 ||
        empty($pluginData['body'])
    ) {
        return $updatePlugins;
    }

    $pluginData = json_decode($pluginData['body']);

    // Should resemble object described here:
    // https://make.wordpress.org/core/2020/07/30/recommended-usage-of-the-updates-api-to-support-the-auto-updates-ui-for-plugins-and-themes-in-wordpress-5-5/
    return (object) [
        'id'            => 'wp-typeit/typeit.php',
        'slug'          => 'wp-typeit',
        'plugin'        => 'wp-typeit/typeit.php',
        'new_version'   => $pluginData->version,
        'url'           => 'https://typeitjs.com',
        'package'       => $pluginData->package,
        'icons'         => [],
        'banners'       => [],
        'banners_rtl'   => [],
        'tested'        => '',
        'requires_php'  => '7.0',
        'compatibility' => new \stdClass(),
    ];
}

function push_update($updatePluginsTransient)
{
    global $pagenow;

    // Only deal with this on the "plugins" page.
    if ($pagenow !== 'plugins.php') {
        return $updatePluginsTransient;
    }

    if (!is_object($updatePluginsTransient)) {
        return $updatePluginsTransient;
    }

    // Guarantee that a `response` property exists.
    if (!isset($update_plugins->response) || !is_array($update_plugins->response)) {
        $updatePluginsTransient->response = [];
    }

    // Do not update if a previously-set transient was found.
    if ($transient = get_transient(TYPEIT_UPDATE_CHECK_TRANSIENT)) {
        $updatePluginsTransient->no_update['wp-typeit/typeit.php'] = $transient;

        return $updatePluginsTransient;
    }

    $pluginData = fetch_remote_data();

    set_transient(
        TYPEIT_UPDATE_CHECK_TRANSIENT,
        $pluginData,
        TYPEIT_TRANSIENT_EXPIRATION
    );

    if (version_compare($pluginData->version, WP_TYPEIT_PLUGIN_VERSION, "<=")) {
        return $updatePluginsTransient;
    }

    $updatePluginsTransient->response['wp-typeit/typeit.php'] = $pluginData;

    return $updatePluginsTransient;
}
