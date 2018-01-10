<?php

/**
 * So here I added 'resources/views/woocommerce' to the $paths,
 * so filter_templates will also look in the woocommerce folder under resources/views.
 */

function filter_templates($templates)
{
    return collect($templates)
        ->map(function ($template) {
            return preg_replace('#\.(blade\.)?php$#', '', ltrim($template));
        })
        ->flatMap(function ($template) {
            $paths = apply_filters('sage/filter_templates/paths', ['views', 'resources/views', 'resources/views/woocommerce']);
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                        "{$template}.blade.php",
                        "{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}
