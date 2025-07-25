@extends('layouts.item_detail')

@section('content')
    <div class="comment-group">
        @foreach ($comments as $comment)
            @if (Auth::id() === $comment['userId'])
                <div class="comment-content comment-content--right">
                    <div class="user-area user-area--right">
                        <span class="user-area__name">{{ $comment['userName'] }}</span>
                        <img class="user-area__image" src="{{ $comment['userIcon'] }}">
                    </div>
                    <div class="comment-area comment-area--right">
                        <p class="comment-area__text">{{ $comment['comment'] }}</p>
                    </div>
                </div>
            @else
                <div class="comment-content">
                    <div class="user-area">
                        <img class="user-area__image" src="{{ $comment['userIcon'] }}">
                        @if ($item->user_id === $comment['userId'])
                            <span class="user-area__name user-area__seller">出品者</span>
                        @else
                            <span class="user-area__name">{{ $comment['userName'] }}</span>
                        @endif
                    </div>
                    <div class="comment-area">
                        <p class="comment-area__text">{{ $comment['comment'] }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <form class="form-group" action="/item/comment/store/{{ $item->id }}" method="post">
        @csrf
        <label class="form-group__label">商品へのコメント
            <textarea class="form-group__textarea" name="comment"rows="5" required></textarea>
        </label>
        <button class="submit-button" type="submit" onclick="return confirm('コメントを送信しますか？')">コメントを送信する</button>
    </form>
@endsection