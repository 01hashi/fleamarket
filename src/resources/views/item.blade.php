@extends('layouts.item_detail')

@section('content')
    @if ($item->soldToUsers()->exists())
        <div class="link-button link-button--disabled">売り切れ</div>
    @elseif ($userItem)
        <a class="link-button link-button--blue" href="/sell/{{ $item->id }}">編集する</a>
    @else
        <a class="link-button" href="/purchase/{{ $item->id }}">購入する</a>
    @endif
    <div class="description-group">
        <h3 class="description-group__title">商品説明</h3>
        <p class="description-group__text">{{ $item->description }}
    </div>
    <div class="information-group">
        <h3 class="information-group__title">商品の情報</h3>
        <div class="information-content">
            <span class="information-content__title">カテゴリー</span>
            <div class="category-unit">
                @foreach ($categories as $category)
                    <span class="information-content__category">{{ $category }}</span>
                @endforeach
            </div>
        </div>
        <div class="information-content">
            <span class="information-content__title">商品の状態</span>
            <span class="information-content__text">{{ $condition }}</span>
        </div>
    </div>
@endsection