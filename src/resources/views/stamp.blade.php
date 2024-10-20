@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('nav')
    <li class="header-nav-item">
        <a class="header__link" href="/">ホーム</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('auth') }}">ユーザー一覧</a>
    </li>
    <li class="header-nav-item">
        <a class="header__link" href="{{ route('date') }}">日付一覧</a>
    </li>
    <li class="header-nav-item">
        <form class="form" action="/logout" method="post">
            @csrf
            <input class="header__btn" type="submit" value="ログアウト">
        </form>
    </li>
@endsection

@section('content')
<div class="stamp__content">
    <div class="stamp-form__heading">
        <p>{{ $user->name }}さんお疲れ様です！</p>
    </div>
    <form class="form" action="/store" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user['id'] }}">
        <div class="work-btn">
            @if($query===null)
            <div class="work-start-btn">
                <button type="submit" name="attendance" value=1>勤務開始</button>
            </div>
            <div class="work-end-btn">
                <button type="submit" name="attendance" value=2 disabled>勤務終了</button>
            </div>
            @elseif($query['attendance']===2)
            <div class="work-start-btn">
                <button type="submit" name="attendance" value=1 disabled>勤務開始</button>
            </div>
            <div class="work-end-btn">
                <button type="submit" name="attendance" value=2 disabled>勤務終了</button>
            </div>
            @else
            <div class="work-start-btn">
                <button type="submit" name="attendance" value=1 disabled>勤務開始</button>
            </div>
            <div class="work-end-btn">
                <button type="submit" name="attendance" value=2>勤務終了</button>
            </div>
            @endif
        </div>
        <div class="rest-btn">
            @if($query===null)
            <div class="rest-start-btn">
                <button type="submit" name="attendance" value=3 disabled>休憩開始</button>
            </div>
            <div class="rest-end-btn">
                <button type="submit" name="attendance" value=4 disabled>休憩終了</button>
            </div>
            @elseif($query['attendance']===3)
            <div class="rest-start-btn">
                <button type="submit" name="attendance" value=3 disabled>休憩開始</button>
            </div>
            <div class="rest-end-btn">
                <button type="submit" name="attendance" value=4>休憩終了</button>
            </div>
            @elseif($query['attendance']===2)
            <div class="rest-start-btn">
                <button type="submit" name="attendance" value=3 disabled>休憩開始</button>
            </div>
            <div class="rest-end-btn">
                <button type="submit" name="attendance" value=4 disabled>休憩終了</button>
            </div>
            @else
            <div class="rest-start-btn">
                <button type="submit" name="attendance" value=3>休憩開始</button>
            </div>
            <div class="rest-end-btn">
                <button type="submit" name="attendance" value=4 disabled>休憩終了</button>
            </div>
            @endif
        </div>
    </form>
</div>
@endsection