@extends('layouts.storefront')

@section('title', 'Pesanan '.$order->order_number)
@section('meta_description', 'Detail pesanan pelanggan beserta status pembayaran dan status pesanan.')

@section('content')
    @include('frontend.orders._detail')
@endsection
