@extends('layouts.storefront')

@section('title', 'Order '.$order->order_number)
@section('meta_description', 'Detail order customer beserta status pembayaran dan status pesanan.')

@section('content')
    @include('frontend.orders._detail')
@endsection
