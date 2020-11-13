<?php

namespace TypeIt;

add_filter('site_transient_update_plugins', '\TypeIt\push_update');
add_filter('transient_update_plugins', '\TypeIt\push_update');
add_filter('plugin_row_meta', '\TypeIt\remove_view_details_link', 10, 4);
add_filter('self_admin_url', '\TypeIt\modify_version_details_url', 10, 3);

define("TYPEIT_TRANSIENT_EXPIRATION", 43200); // 12 hours
define("TYPEIT_UPDATE_CHECK_TRANSIENT", "wp_update_check_wp_typeit");

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

function push_update($updatePlugins)
{
    global $pagenow;

    if ($pagenow !== 'plugins.php') {
        return $updatePlugins;
    }

    if (!is_object($updatePlugins)) {
        return $updatePlugins;
    }

    if (!isset($update_plugins->response) || !is_array($update_plugins->response)) {
        $updatePlugins->response = [];
    }

    if ($transient = get_transient(TYPEIT_UPDATE_CHECK_TRANSIENT)) {
        $updatePlugins->response['wp-typeit/typeit.php'] = $transient;

        return $updatePlugins;
    }

    $pluginData = wp_remote_get(
        'https://wp-plugin-update.now.sh/api/plugin/wp-typeit',
        [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]
    );

    if (
        is_wp_error($pluginData) ||
        ($pluginData['response']['code'] ?? null) !== 200 ||
        empty($pluginData['body'])
    ) {
        return $updatePlugins;
    }

    $pluginData = json_decode($pluginData['body']);
    $responseObject = (object) [
        'slug'         => 'wp-typeit',
        'new_version'  => $pluginData->version,
        'url'          => 'https://typeitjs.com',
        'package'      => $pluginData->package
    ];

    set_transient(
        TYPEIT_UPDATE_CHECK_TRANSIENT,
        $responseObject,
        TYPEIT_TRANSIENT_EXPIRATION
    );

    // Don't show `update` notice unless the remote version is newer. 
    if (version_compare($pluginData->version, WP_TYPEIT_PLUGIN_VERSION, "<=")) {
        return $updatePlugins;
    }

    $updatePlugins->response['wp-typeit/typeit.php'] = $responseObject;

    return $updatePlugins;
}
