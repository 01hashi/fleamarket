@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('main')
    @if (session('success'))
        <div class="message-success" id="message">
            {{ session('success') }}
        </div>
        <script>
            $(document).ready(function(){
                $("#message").fadeIn(1000).delay(3000).fadeOut(1000);
            });
        </script>
    @endif

    <h2 class="main-title">商品の出品</h2>
    <form class="form-wrap" action="{{ isset($item_id) ? '/sell/' . $item_id : '/sell' }}" method="post" enctype="multipart/form-data">
        @csrf
        <span class="form-wrap__label">商品画像
            @if($item)
                <a class="image-link" href="{{ $item->img_url}}">
                    <img class="preview-image" id="preview-image" src="{{ $item->img_url }}">
                </a>
            @else
                <img class="preview-image" id="preview-image" style="display: none">
            @endif
            <div class="image-group">
                <label class="image-group__label">
                    <input class="image-group__input" type="file" id="image" name="img_url" onchange="previewFile()">画像を選択する
                </label>
            </div>
        </span>
        @error('img_url')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">商品の詳細</h3>
        <label class="form-wrap__label">カテゴリー
            <select class="form-wrap__select" name="category_id">
                <option disabled  {{ collect($selectCategories)->every('selected', false) ? 'selected' : '' }}>--- 選択してください ---</option>
                @foreach ($selectCategories as $category)
                    <option value="{{ $category['id'] }}" {{ $category['selected'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                @endforeach
            </select>
        </label>
        @error('category_id')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <label class="form-wrap__label">商品の状態
            <select class="form-wrap__select" name="condition_id">
                <option disabled {{ collect($conditions)->every('selected',false) ? 'selected' : '' }}>--- 選択してください ---</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}"  {{ $selectedConditionId == $condition->id ? 'selected' : '' }}>{{ $condition->condition }}</option>
                @endforeach
            </select>
        </label>
        @error('condition_id')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">商品名と説明</h3>
        <label class="form-wrap__label">商品名
            <input class="form-wrap__input" type="text" name="name" value="{{ $item->name ?? '' }}">
        </label>
        @error('name')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <label class="form-wrap__label">商品の説明
            <textarea class="form-wrap__textarea" name="description" cols="30" rows="5">{{ $item->description ?? '' }}</textarea>
        </label>
        @error('description')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">販売価格</h3>
        <label class="form-wrap__label">販売価格
            <div class="input-wrap">
                <input class="form-wrap__input input-price" type="text" id="price" name="price"  value="{{ $item->price ?? '' }}" pattern="^[1-9][0-9]*$">
            </div>
        </label>
        @error('price')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <input type="hidden" value="{{ Auth::id() }}" name="user_id">
        <button class="form-wrap__button" type="submit" onclick="return confirm('出品しますか？')">{{ $item ? '修正する' : '出品する' }}</button>
    </form>

    <script src="https:ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function previewFile() {
            var preview = document.getElementById('preview-image');
            var file    = document.querySelector('input[type=file]').files[0];
            var reader  = new FileReader();

            if (file) {
                reader.onloadend = function () {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('price');

            const formatToCommaSeparated = (value) => {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            };

            if (amountInput.value) {
                amountInput.value = formatToCommaSeparated(amountInput.value);
            }

            amountInput.addEventListener('focus', function(e) {
                let value = e.target.value;
                e.target.value = value.replace(/,/g, '');
            });

            amountInput.addEventListener('blur', function(e) {
                let value = e.target.value;

                value = value.replace(/[０-９]/g, function(s) {
                    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
                }).replace(/[^0-9]/g, '');

                e.target.value = formatToCommaSeparated(value);
            });
        });
    </script>
@endsection