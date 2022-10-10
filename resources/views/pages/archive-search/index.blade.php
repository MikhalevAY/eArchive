@extends('layouts.app')

@section('title', 'Поиск в архиве')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            @include('components.search-documents', ['formRoute' => 'archiveSearchList'])
        </div>
    </div>
@endsection
