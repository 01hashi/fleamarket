@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
    <div class="user-wrap">
        <div class="user-group">
            <img class="user-group__icon" src="{{ $img_url }}">
            <div class="user-unit">
                <p class="user-unit__shop">{{ optional($shop)->name ? '[' . $shop->name  .']' : '' }}</p>
                <p class="user-unit__name">{{ $user->name }}</p>
            </div>
        </div>
        <a class="user-wrap__profile" href="/mypage/profile">プロフィールを編集</a>
    </div>

    <div class="tab-wrap">
        <label class="tab-wrap__label">
            <input class="tab-wrap__input" type="radio" name="tab" value="sell_items" checked>出品した商品
        </label>
        <div class="tab-wrap__group">
            @foreach ($sellItems as $item)
                <div class="tab-wrap__content">
                    @if ($item->soldToUsers()->exists())
                        <div class="sold-out__mark">SOLD OUT</div>
                    @endif
                    <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                        <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                    </a>
                </div>
            @endforeach

            @for ($i = 0; $i < 10; $i++)
                <div class="tab-wrap__content dummy"></div>
            @endfor
        </div>

        @if(!$hasAnyRole)
            <label class="tab-wrap__label">
                <input class="tab-wrap__input" type="radio" value="bought_items" name="tab">購入した商品
            </label>
            <div class="tab-wrap__group">
                @foreach ($soldItems as $item)
                    <div class="tab-wrap__content">
                        <div class="sold-out__mark">SOLD OUT</div>
                        <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                            <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                        </a>
                    </div>
                @endforeach

                @for ($i = 0; $i < 10; $i++)
                    <div class="tab-wrap__content dummy"></div>
                @endfor
            </div>
        @endif

        @hasanyrole('Admin|ShopOwner')
            <label class="tab-wrap__label">
                <input class="tab-wrap__input" type="radio" name="tab" value="user_list">権限一覧
            </label>
            <div class="tab-wrap__group">
                @can('delete-user')
                    <div class="tab-wrap__content">
                        <a class="tab-wrap__content-link" href="/admin/show-users">
                            <div class="permission-text">ユーザー一覧</div>
                            <img class="tab-wrap__content-image object-fit--contain" src="{{ asset('img/users.svg') }}">
                        </a>
                    </div>
                @endcan

                @can('view-interactions')
                    <div class="tab-wrap__content">
                        <a class="tab-wrap__content-link" href="/admin/show-shops">
                            <div class="permission-text">ショップ一覧</div>
                            <img class="tab-wrap__content-image object-fit--contain" src="{{ asset('img/shops.svg') }}">
                        </a>
                    </div>
                @endcan

                @can('send-email')
                    <div class="tab-wrap__content">
                        <a class="tab-wrap__content-link" href="/admin/notification">
                            <div class="permission-text">メール送信</div>
                            <img class="tab-wrap__content-image object-fit--contain" src="{{ asset('img/send_email.svg') }}">
                        </a>
                    </div>
                @endcan

                @can('manage-shop-staff')
                    <div class="tab-wrap__content">
                        <a class="tab-wrap__content-link" href="/shop-owner/manage-shop-staff/{{ $shop->id }}">
                            <div class="permission-text">スタッフ管理</div>
                            <img class="tab-wrap__content-image object-fit--contain" src="{{ asset('img/shop_staff.svg') }}">
                        </a>
                    </div>
                @endcan

                @for ($i = 0; $i < 10; $i++)
                    <div class="tab-wrap__content dummy"></div>
                @endfor
            </div>
        @endhasanyrole
    </div>
@endsection