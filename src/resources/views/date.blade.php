@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
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
    <form class="form" action="/attendance" method="get">
        @csrf
        <div class="attendance-form__heading">
            @php
                use Carbon\Carbon;
                $today = Carbon::today()->format('Y-m-d');
            @endphp
            @if ($date == $today)
            <button type="submit" name="addDay" disabled>&lt;</button>
            @else
            <button type="submit" name="addDay">&lt;</button>
            @endif
            <span>{{ $date }}</span>
            <button type="submit" name="subDay">&gt;</button>
            <input type="hidden" name="date" value="{{ $date }}">
        </div>
        <table class="attendance-table">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">名前</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
                <th></th>
            </tr>
            @foreach($items as $item)
            <tr class="attendance-table__row">
                <td class="attendance-table__item">{{ $item['name'] }}</td>
                <td class="attendance-table__item">{{ $item['workIn'] }}</td>
                <td class="attendance-table__item">{{ $item['workOut'] }}</td>
                <td class="attendance-table__item">{{ $item['restTime'] }}</td>
                <td class="attendance-table__item">{{ $item['workTime'] }}</td>
            </tr>
            @endforeach
        </table>
    </form>
    <div class="pagination">{{ $items->appends(['date' => $date])->links('pagination::bootstrap-4') }}</div>
</div>
@endsection