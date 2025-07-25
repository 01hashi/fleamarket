@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
    <div class="tab-wrap">
        <label class="tab-wrap__label recommendation__label">
            <input class="tab-wrap__input" type="radio" name="tab" checked>おすすめ
        </label>
        <div class="tab-wrap__group">
            @foreach ($items as $item)
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

        <label class="tab-wrap__label">
            <input class="tab-wrap__input" type="radio" name="tab">マイリスト
        </label>
        @if (Auth::check())
            <div class="tab-wrap__group">
                @forelse ($likeItems as $likeItem)
                    <div class="tab-wrap__content">
                        @if ($likeItem->soldToUsers()->exists())
                            <div class="sold-out__mark">SOLD OUT</div>
                        @endif
                        <a class="tab-wrap__content-link" href="/item/{{ $likeItem->id }}">
                            <img class="tab-wrap__content-image" src="{{ $likeItem->img_url }}">
                        </a>
                    </div>
                @empty
                    <p class="no-message">マイリストはありません</p>
                @endforelse

                @for ($i = 0; $i < 10; $i++)
                    <div class="tab-wrap__content dummy"></div>
                @endfor
            </div>
        @else
            <div class="tab-wrap__group-link">
                <a class="link-button" href="/register">会員登録</a>
                <span class="tab-wrap__group-text">及び</span>
                <a class="link-button" href="/login">ログイン</a>
                <span class="tab-warp__group-text">が必要です。</span>
            </div>
        @endif
    </div>
@endsection