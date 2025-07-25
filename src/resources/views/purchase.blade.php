@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('main')
    @if (session('success'))
        <div class="message-success" id="message">
            {{ session('success') }}
        </div>
        <script src="https:ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#message").fadeIn(1000).delay(3000).fadeOut(1000);
            });
        </script>
    @endif

    <div class="section-wrap">
        <div class="section-group">
            <div class="image-content">
                <img class="image-content__image" src="{{ $item->img_url }}" alt="商品画像">
            </div>
            <div class="item-content">
                <h2 class="item-content__title">{{ $item->name }}</h2>
                <p class="item-content__price">￥{{ number_format($item->price) }}</p>
            </div>
        </div>
        <div class="payment-group">
            <div class="header-content">
                <h3 class="header-content__title">支払方法</h3>
                <a class="link-button" href="/purchase/payment/{{ $item->id }}">変更する</a>
            </div>
            <div class="payment-content">
                <p class="payment-content__text">{{ $paymentMethod ?? ''}}</p>
                @error('payment_id')
                    <p class="payment-content__text payment-content__text-error">{{ $errors->first('payment_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="address-group">
            <div class="header-content">
                <h3 class="header-content__title">配送先</h3>
                <a class="link-button" href="/purchase/address/{{ $item->id }}">変更する</a>
            </div>
            <div class="address-content">
                <p class="address-content__text">〒{{ substr($profile->postcode, 0, 3) . '-' . substr($profile->postcode, 3) }}</p>
                <p class="address-content__text">{{ $profile->address }} <span>{{ $profile->building }}</span></p>
            </div>

        </div>
    </div>

    <form class="confirm-wrap" action="/purchase/decide/{{ $item->id }}" method="post">
        @csrf
        <div class="confirm-group">
            <div class="confirm-content confirm-content__price">
                <p class="confirm-content__title">商品代金</p>
                <p class="confirm-content__text">￥{{ number_format($item->price) }}</p>
            </div>
            <div class="confirm-content confirm-content__total">
                <p class="confirm-content__title">支払い金額</p>
                <p class="confirm-content__text">￥{{ number_format($item->price) }}</p>
            </div>
            <div class="confirm-content confirm-content__payment">
                <p class="confirm-content__title">支払方法</p>
                <p class="confirm-content__text">{{ $paymentMethod ?? '' }}</p>
            </div>
        </div>
        <input type="hidden" name="payment_id" value="{{ $paymentId }}">
        <button class="submit-button" type="submit" onclick="return confirm('購入しますか？')">購入する</button>
    </form>
@endsection