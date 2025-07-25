@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('main')
    <script src="https://js.stripe.com/v3/"></script>
    <div class="header__title">
        <img class="header__image" src="{{ asset('img/card.svg') }}">
        <p class="header__text">支払い方法の選択</p>
    </div>
    <form class="payment-wrap" action="/purchase/payment/select/{{ $item_id }}" method="post">
        @csrf
        <div class="payment-inner">
            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment" value="1" checked>クレジットカード
                    <span class="card-brand__area">
                        <img class="card-brand__area-img" src="{{ asset('img/jcb.png') }}" alt="JCB">
                        <img class="card-brand__area-img" src="{{ asset('img/mastercard.png') }}" alt="MasterCard">
                        <img class="card-brand__area-img" src="{{ asset('img/visa.png') }}" alt="Visa">
                    </span>
                </label>

                <div class="payment-group">
                    <table class="payment-table" style="display: none">
                        <tr class="payment-row">
                            <td class="card-image">
                                <label class="payment-label">
                                    <div class="radio-list">
                                        <input class="card-radio" type="radio" name="credit" checked>
                                        <img class="card-brand__image" src="{{ asset('img/jcb.png') }}" alt="">
                                    </div>
                                </label>
                            </td>
                            <td class="card-brand">{{-- カードブランド --}}</td>
                            <td class="card-number">{{-- 下4桁 カード番号 --}}</td>
                            <td class="card-limit">{{-- 年/月 --}}</td>
                            <td class="card-name">{{-- 名義 --}}</td>
                            <td class="payment-select">
                                <select class="payment-list" name="" id="">
                                    <option value="1" selected>一括払い</option>
                                    <option value="-2">リボ払い</option>
                                    <option value="3">3回</option>
                                    <option value="5">5回</option>
                                    <option value="10">10回</option>
                                    <option value="12">12回</option>
                                    <option value="18">18回</option>
                                    <option value="24">24回</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="create-card__list">
                        <div class="create-card__row payment-row">
                            <label class="create-card__label">
                                <input class="card-radio card-radio__create" type="radio" name="credit">新しくカードを追加する
                            </label>
                            <div class="create-card__group">
                                <div class="create-card__box">
                                    <div class="create-card__area">
                                        <p class="create-card__title">カード番号</p>
                                        <input class="input-number" id="credit-card-number" type="text" size="20" maxlength="19" placeholder="0000 0000 0000 0000">
                                    </div>
                                    <div class="create-card__area">
                                        <p class="create-card__title">有効期限</p>
                                        <div class="create-card__select">
                                            <select class="select-limit" name="month">
                                                <option hidden>月</option>
                                                @for ($i = 1; $i < 13; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                @endfor
                                            </select>
                                            <select class="select-limit" name="year">
                                                <option hidden>年</option>
                                                @for ($i = 2023; $i < 2043; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="create-card__box">
                                    <div class="create-card__area">
                                        <p class="create-card__title">カードに記載された名前</p>
                                        <input class="input-name" type="text" size="41" maxlength="41" placeholder="TARO YAMADA">
                                    </div>
                                    <input class="input-button" type="button" value="追加"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment" value="2">銀行振込
                </label>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment" value="3">後払い決済
                </label>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment" value="4">代金引換
                </label>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment" value="5">コンビニ払い
                </label>
            </div>
        </div>
        <input type="hidden">
        <button class="submit-button" type="submit">変更する</button>
    </form>
    <script>
        const visaImageUrl = "{{ asset('img/visa.png') }}";
        const mastercardImageUrl = "{{ asset('img/mastercard.png') }}";
        const jcbImageUrl = "{{ asset('img/jcb.png') }}";
    </script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection