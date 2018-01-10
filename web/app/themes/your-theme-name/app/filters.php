<?php

/**
 * This is basically the same as mtxz's add_filter but with some changes
 * because we edited the filter_templates function in helpers.php to look in the correct folder.
 *
 * Basically removed 'resources/views' from the if statements.
 */

add_filter('wc_get_template_part', function ($template, $slug, $name, $args) {

    $bladeTemplate = false;

    // Look in yourtheme/slug-name.blade.php and yourtheme/woocommerce/slug-name.blade.php
    if ($name && !WC_TEMPLATE_DEBUG_MODE) {
        $bladeTemplate = locate_template(["{$slug}-{$name}.blade.php", WC()->template_path() . "{$slug}-{$name}.blade.php"]);
    }

    // If template file doesn't exist, look in yourtheme/slug.blade.php and yourtheme/woocommerce/slug.blade.php
    if (!$template && !WC_TEMPLATE_DEBUG_MODE) {
        $bladeTemplate = locate_template(["{$slug}.blade.php", WC()->template_path() . "{$slug}.blade.php"]);
    }

    if ($bladeTemplate) {
        echo template($bladeTemplate, $args);

        // Return a blank file to make WooCommerce happy
        //return get_theme_file_path('index.php');
        return null;
    }

    //try to look for PHP files within resources/views/woocommerce
    $normalTemplate = false;
    if ($name && !WC_TEMPLATE_DEBUG_MODE) {
        $normalTemplate = locate_template(["{$slug}-{$name}.php", WC()->template_path() . "{$slug}-{$name}.php"]);
    }
    if (!$normalTemplate && !WC_TEMPLATE_DEBUG_MODE) {
        $normalTemplate = locate_template(["{$slug}.php", WC()->template_path() . "{$slug}.php"]);
    }

    if ($normalTemplate) {
        return get_theme_file_path($normalTemplate); //work even without
    }

    return $template;

}, PHP_INT_MAX, 4);

/**
 * This is still a work in progress.
 * I have been wanting to change this so it can actually read blade files,
 * with the code provided by mtxz it just removes the .php extension and replaces it with .blade.php
 *
 * But you can't actually use it like a .blade.php file
 *
 * I quoted out mtxz's original code because I had some trouble with it not rendering blade files.
 */

add_filter('wc_get_template', function ($located, $template_name, $args, $template_path, $default_path) {

//    $bladeTemplateName = str_replace('.php', '.blade.php', $template_name);
//    var_dump($bladeTemplateName);
//    $bladeTemplate = locate_template([$bladeTemplateName, 'resources/views/' . WC()->template_path() . $bladeTemplateName]);

    $bladeTemplate = locate_template([$template_name, 'resources/views/' . WC()->template_path() . $template_name]);

    if ($bladeTemplate) {
        return template_path($bladeTemplate, $args);
    }

    return $located;
}, PHP_INT_MAX, 5);
