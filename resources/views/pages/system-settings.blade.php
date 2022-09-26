@extends('layouts.app')

@section('title', 'Настройка системы')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="{{ route('updateSystemSetting') }}">
                <div class="row">
                    <span class="large">Логотип</span>
                    <div class="file-block">
                        <div class="uploaded-file">
                            <div class="logo">
                                <img src="/storage/{{ $systemSetting->logo }}" alt="" draggable="false">
                            </div>
                            <div class="info">
                                <h3>{{ $file['name'] }}</h3>
                                {{ $file['size'] }} Kb {{ $file['ext'] }}
                            </div>
                            <a class="delete delete-file"></a>
                        </div>
                        <label class="file-label hidden" for="logo">
                            <div><i class="file-name">Выберите файл</i></div>
                            <input class="file-input" id="logo" type="file" name="logo">
                        </label>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row left">
                    <span class="large">Базовый цвет</span>
                    <div class="colors">
                        @foreach($colors as $color)
                            @if($systemSetting->color == $color)
                                <div class="color active" style="border-color: {{ $color }}" data-border="{{ $color }}">
                            @else
                                <div class="color" data-border="{{ $color }}">
                            @endif
                                <span style="background: {{ $color }}"></span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row left">
                    <span class="large">Свой вариант</span>
                    <div class="colorChooser">
                        <input type="color" class="colorInput" value="{{ $systemSetting->color }}">
                        <b>{{ $systemSetting->color }}</b>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="divider"></div>
                <input type="hidden" name="color" value="{{ $systemSetting->color }}">
                <input type="submit" value="Применить">
                <div class="result"></div>
            </form>
        </div>
    </div>
@endsection
