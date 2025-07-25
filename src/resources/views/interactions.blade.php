@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/interactions.css') }}">
@endsection

@section('main')
    <h2 class="main-title">ユーザーとのやり取り</h2>
    <div class="comment-group">
        @foreach ($comments as $comment)
            @if ($comment['shopStaff'])
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
                        <span class="user-area__name">{{ $comment['userName'] }}</span>
                    </div>
                    <div class="comment-area">
                        <p class="comment-area__text">{{ $comment['comment'] }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection