@extends('layouts.app')

@section('title', 'Новый пароль')

@section('content-class', 'center')

@section('content')
    <div class="login-form">
        <h2>@yield('title')</h2>
        <h4>Придумайте новый пароль.</h4>
        <form action="{{ route('updatePassword') }}" method="post">
            @csrf
            <div class="row">
                <span>Новый пароль</span>
                <input type="password" name="new_password" placeholder="Пароль" autocomplete="off"/>
                <div class="eye"></div>
            </div>
            <div class="row">
                <span>Повторите пароль</span>
                <input type="password" name="repeat_password" placeholder="Повторите пароль" autocomplete="off"/>
                <div class="eye"></div>
            </div>
            <input type="submit" value="Сохранить"/>
            <div class="result text-center"></div>
        </form>
    </div>
    <div class="login-form-ball"></div>
@endsection
