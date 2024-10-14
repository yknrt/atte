@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
@endsection

@section('nav')
<!-- <nav>
    <ul class="header-nav"> -->
    <li class="header-nav-item">
        <a class="header__link" href="../">ホーム</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('user') }}">ユーザー一覧</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('date') }}">日付一覧</a>
    </li>
    <li class="header-nav-item">
        <form>
            <input class="header__btn" type="submit" value="ログアウト">
        </form>
    </li>
    <!-- </ul>
</nav> -->
@endsection

@section('content')
<div class="attendance__content">
    <form class="form" action="/attendanceUsers" method="get">
        @csrf
        <div class="attendance-form__heading">
            <select name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if(old('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
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
    <div class="pagination">{{ $items->appends(['date' => $date])->links('pagination::bootstrap-4') }}</div>
</div>
@endsection