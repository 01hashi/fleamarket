@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
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
    <h2 class="main-title">メール送信</h2>
    <div class="notification__wrap">
        <div class="notification__content">
            <form action="/admin/send-notification" method="post" class="notification__form">
                @csrf
                <div class="notification__group--flex">
                    <p class="notification__title">宛先</p>
                    <select name="destination" id="destination" size="1" class="destination__select">
                        <option value="all">全員</option>
                        <option value="user">ユーザー</option>
                        <option value="ShopOwner">店舗代表者</option>
                        <option value="Admin">管理者</option>
                    </select>
                </div>

                <div class="notification__group">
                    <p class="notification__title notification__title-textarea">本文</p>
                    <textarea class="notification__textarea" name="message" rows="10"  required></textarea>
                </div>
                <div class="form__button">
                    <button type="submit" class="form__button-btn">メール送信</button>
                </div>
            </form>
        </div>
    </div>
@endsection