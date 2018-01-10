{{--
    This file is the main page of the shop, so the overview of all products before choosing a category

    Here we look for a product template, named content-product.blade.php
    and then render this file while posts have posts
--}}

@extends('layouts.app')

@include('partials.headers.woocommerce-header')

@section('content')
    <div class="container">
        <div class="row">
            @while(have_posts()) @php(the_post())

            {{ App\wc_get_template_part('content', 'product', null, get_defined_vars()) }}

            @endwhile
        </div>
    </div>
@endsection
