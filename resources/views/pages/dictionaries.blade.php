@extends('layouts.app')

@section('title', 'Справочники')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <div class="dictionaries">
                @foreach($typeTitle as $type => $title)
                    <div class="dictionary closed">
                        <h1>{{ $title }}</h1>
                        <div class="items elements" data-type="{{ $type }}">
                            @foreach($byType[$type] as $item)
                                <div class="item" data-row="{{ $item->id }}">
                                    {{ $item->title }}
                                    <a class="modal-link delete right"
                                       data-url="{{ route('deleteDictionaryItem', ['dictionary' => $item]) }}"></a>
                                </div>
                            @endforeach
                            <input type="button" value="Добавить" class="modal-link no-bg"
                                   data-url="{{ route('newDictionaryItem', ['type' => $type]) }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
