<?php

/**
 * This uses the Template function from helpers.php.
 * So it can render the proper & wanted template.
 *
 * It is basically a redirect to the resources/views/woocommerce directory
 * where it needs to look foor archive-product.blade.php and render that.
 *
 * So we just fool Wordpress & Woocommerce with this.
 */

    $template = 'woocommerce.archive-product';
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);

    echo App\Template($template, $data);
