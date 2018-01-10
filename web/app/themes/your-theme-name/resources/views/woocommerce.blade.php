{{--
  This file will call the woocommerce_content from setup with the get_definded_vars property.
  Don't know if it is necessary like the woocommerce_content from setup.php
--}}

@extends('layouts.app')

@include('partials.headers.woocommerce-header')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">

        {!! App\woocommerce_content(get_defined_vars()) !!}

      </div>
    </div>
  </div>
@endsection
