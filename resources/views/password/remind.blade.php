@extends('layouts.app')

@section('title', 'Восстановить пароль')

@section('content-class', 'center')

@section('content')
<div class="login-form">
    <img src="/images/samruk-logo.svg" alt="" draggable="false">
    <h2>@yield('title')</h2>
    <h4>Введите e-mail, привязанный к вашему аккаунту.</h4>
    <form action="{{ route('restorePassword') }}" method="post">
        @csrf
        <div class="row">
            <span>E-mail</span>
            <input type="text" name="email" placeholder="Ваш e-mail" autocomplete="off" />
        </div>
        <input type="submit" value="Восстановить"/>
        <p class="text-center top-20">
            <a href="/">Авторизоваться</a>
        </p>
        <div class="result text-center"></div>
    </form>
</div>
<div class="login-form-ball"></div>
@endsection
