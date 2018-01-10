{{--
    This file acutally renders the product
    after you clicked on it from the main shop page.

    Here you can add your own magic & styling.

    So here we can finally use the wc_get_template function.

    This will load a template specific to the title for instance.

    App\wc_get_template('single-product/title.php') will look
    in the resources/views/woocommerce/single-product folder
    for a file named title.php and then render it.
--}}

@php
  global $product;
@endphp

<div class="col-6">
  <div class="img-fluid">
    {{ App\wc_get_template('single-product/product-image.php') }}
  </div>
</div>
<div class="col-6">

  {{ App\wc_get_template('single-product/title.php') }}
  {{ App\wc_get_template('single-product/rating.php') }}
  {{ App\wc_get_template('single-product/price.php') }}
  {{ App\wc_get_template('single-product/short-description.php') }}
  {{ App\wc_get_template('single-product/meta.php') }}
  {{ App\wc_get_template('add-to-cart/simple.php') }}
  {{ App\wc_get_template('single-product/reviews.php') }}
  {{ App\wc_get_template_part('single', 'product-review') }}

</div>

<div class="col-12">
  {!! do_action( 'woocommerce_after_single_product' ) !!}
</div>
