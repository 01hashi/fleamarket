@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
    <h2 class="main-title">ユーザー一覧</h2>
    <div class="tab-wrap__group table__group">
        <table class="table">
            <tr class="table__row">
                <th class="table__header users-table__id">ID</th>
                <th class="table__header users-table__name">Name</th>
                <th class="table__header users-table__email">Email</th>
                <th class="table__header users-table__delete"></th>
            </tr>
            @foreach ($users as $user)
            <tr class="table__row">
                <td class="table__data users-table__id">{{ $user->id }}</td>
                <td class="table__data users-table__name">{{ $user->name }}</td>
                <td class="table__data users-table__email">{{ $user->email }}</td>
                <td class="table__data users-table__delete">
                    <form class="form__wrap" action="/admin/delete-user" method="post">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button class="submit-button" type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $users->links('vendor/pagination/paginate') }}
    </div>
@endsection