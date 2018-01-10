{{--
    This is a single product being rendered for the main page overview

    Here we actually load product related content like images etc.
    This is still just a overview of a single product.
    for example the main page of the shop (archive.product.blade.php)

    With the global $product we are able to access all it's contents
    Use Woocommerce/includes/abstracts/abastract-wc-product.php for reference
--}}

@php
    global $product;
@endphp

<div class="col-3">

    {!! woocommerce_template_loop_product_link_open() !!}
    <div class="card" style="width: 100%;">
        <div class="card-img-top">{!! $product->get_image() !!}</div>
        <div class="card-body">
            <h4 class="card-title">{!! $product->get_name() !!}</h4>
            <p class="card-text">@php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) @endphp</p>
            <p class="card-text">{!! $product->get_price_html() !!}</p>
            <a href="{!! $product->add_to_cart_url() !!}" class="btn btn-primary">Go somewhere</a>

            {!! $product->add_to_cart_url() !!}

        </div>
    </div>
    {!! woocommerce_template_loop_product_link_close() !!}

</div>
