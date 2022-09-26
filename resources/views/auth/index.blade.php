@extends('layouts.app')

@section('title', 'Авторизация')

@section('content-class', 'center')

@section('content')
<div class="login-form">
    <img src="/storage/{{ $companyLogo }}" alt="" draggable="false">
    <h2>@yield('title')</h2>
    <h4>Добро пожаловать! Войдите в свой аккаунт.</h4>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="row">
            <span>Логин</span>
            <input type="text" name="email" placeholder="Логин" autocomplete="off" />
        </div>
        <div class="row">
            <span>Пароль</span>
            <input type="password" name="password" placeholder="••••••" autocomplete="off"/>
            <div class="eye"></div>
        </div>
        <p class="text-right">
            <a href="{{ route('remindPassword') }}">Забыли пароль?</a>
        </p>
        <input type="submit" value="Авторизоваться"/>
        <div class="result text-center"></div>
    </form>
</div>
<div class="login-form-ball"></div>
@endsection
