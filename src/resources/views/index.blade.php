@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
    <div class="section-header">
        <h2>おすすめ</h2>
    </div>
    <div class="recommendation-group">
        @foreach ($items as $item)
            <div class="item">
                @if ($item->soldToUsers()->exists())
                    <div class="sold-out__mark">SOLD OUT</div>
                @endif
                <a class="item-link" href="/item/{{ $item->id }}">
                <img class="item-image" src="{{ $item->img_url }}">
                </a>
                </div>
        @endforeach

            @for ($i = 0; $i < 10; $i++)
            <div class="item dummy"></div>
            @endfor
        </div>

        <div class="section-header">
        <h2>マイリスト</h2>
        </div>
            @if (Auth::check())
            {{-- ログインしている場合のマイリスト内容 --}}
                @forelse ($FavoritesItems as $FavoritesItem)
                <div class="item">
                    <div class="tab-wrap__content">
                        @if ($FavoritesItem->soldToUsers()->exists())
                            <div class="sold-out__mark">SOLD OUT</div>
                        @endif
                        <a class="item-link" href="/item/{{ $FavoritesItem->id }}">
                        <img class="item-image" src="{{ $FavoritesItem->img_url }}" alt="商品画像">
                        </a>
                    </div>
                @empty
                    <p class="no-message">マイリストはありません</p>
            @endif
        @endforelse
    </div>
@endsection