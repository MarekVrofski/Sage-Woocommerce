<?php

/**
 * This is a exact copy from mtxz's example
 */

function wc_get_template_part( $slug, $name = '', $third = null, $args = []) {
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
    if ( $name && ! WC_TEMPLATE_DEBUG_MODE ) {
        $template = locate_template( array( "{$slug}-{$name}.php", WC()->template_path() . "{$slug}-{$name}.php" ) );
    }

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( WC()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
        $template = WC()->plugin_path() . "/templates/{$slug}-{$name}.php";
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
    if ( ! $template && ! WC_TEMPLATE_DEBUG_MODE ) {
        $template = locate_template( array( "{$slug}.php", WC()->template_path() . "{$slug}.php" ) );
    }

    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters( 'wc_get_template_part', $template, $slug, $name, $args );

    if ( $template ) {
        load_template( $template, false );
    }
}

/**
 * In mtxz's example he edit's woocommerce_content, I thought it wasn't necessary to include it
 * but I copied it aswell. Because in resources/views/woocommerce.blade.php we call to it.
 *
 * Still need to test if it is necessary.
 */

function woocommerce_content($args = [])
{
    if (is_singular('product')) {

        while (have_posts()) : the_post();

            wc_get_template_part('content', 'single-product', null, $args);

        endwhile;
    } else {  ?>

        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="page-title"><?php /*woocommerce_page_title(); */?></h1>

        <?php endif; ?>

        <?php do_action('woocommerce_archive_description'); ?>

        <?php if (have_posts()) : ?>

            <?php do_action('woocommerce_before_shop_loop'); ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php woocommerce_product_subcategories(); ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php wc_get_template_part('content', 'product', null, $args); ?>

            <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php do_action('woocommerce_after_shop_loop'); ?>

        <?php elseif (!woocommerce_product_subcategories(['before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)])) : ?>

            <?php do_action('woocommerce_no_products_found'); ?>

        <?php endif;
    }
}

/**
 * This is almost a exact copy from the original Woocommerce plugin file,
 * the main difference is that I removed:
 *
 * if ( ! $defaulth_path ) {
 *  $default_path = WC()->plugin_path() . '/templates/';
 * }
 *
 * Because this makes the function look in the Woocommerce plugin templates directory, which is unwanted behaviour.
 *
 */

function wc_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = WC()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = WC()->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name,
        )
    );

    // Get default template/
    if ( ! $template || WC_TEMPLATE_DEBUG_MODE ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return apply_filters( 'woocommerce_locate_template', $template, $template_name, $template_path );
}

/**
 * This remaind a exact copy from the wp-core-functions.php file.
 */

function wc_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

    if ( ! empty( $args ) && is_array( $args ) ) {
        extract( $args );
    }

    $located = wc_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        wc_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'woocommerce' ), '<code>' . $located . '</code>' ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $located = apply_filters( 'wc_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'woocommerce_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );

    do_action( 'woocommerce_after_template_part', $template_name, $template_path, $located, $args );
}
