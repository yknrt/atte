@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('nav')
    <li class="header-nav-item">
        <a class="header__link" href="../">ホーム</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('auth') }}">ユーザー一覧</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('date') }}">日付一覧</a>
    </li>
    <li class="header-nav-item">
        <form>
            <input class="header__btn" type="submit" value="ログアウト">
        </form>
    </li>
@endsection

@section('content')
<div class="attendance__content">
    <form class="form" action="/attendanceUser/search" method="get">
        @csrf
        <div class="attendance-form__heading">
            <select name="user_id">
                @foreach ($registers as $register)
                    <option value="{{ $register->id }}" @if($uid == $register->id) selected @endif>{{ $register->name }}</option>
                @endforeach
            </select>
            <button type="submit" name="search">検索</button>
        </div>
        <table class="attendance-table">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">日付</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
                <th></th>
            </tr>
            @foreach($items as $item)
            <tr class="attendance-table__row">
                <td class="attendance-table__item">{{ $item['date'] }}</td>
                <td class="attendance-table__item">{{ $item['workIn'] }}</td>
                <td class="attendance-table__item">{{ $item['workOut'] }}</td>
                <td class="attendance-table__item">{{ $item['restTime'] }}</td>
                <td class="attendance-table__item">{{ $item['workTime'] }}</td>
            </tr>
            @endforeach
        </table>
    </form>
    <div class="pagination">{{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
</div>
@endsection