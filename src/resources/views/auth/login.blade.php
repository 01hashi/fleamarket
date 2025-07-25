@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

<h2 class="main-title">ログイン</h2>
    <form class="form-wrap" action="/login" method="post">
        @csrf
        <label class="form-wrap__label">メールアドレス
            <input class="form-wrap__input" type="email" name="email" value="{{ old('email') }}">
        </label>
        @error('email')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <label class="form-wrap__label">パスワード
            <input class="form-wrap__input" type="password" name="password">
        </label>
        @error('password')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <button class="form-wrap__button" type="submit">ログインする</button>
        <a class="form-wrap__link" href="/register">会員登録はこちら</a>
    </form>
