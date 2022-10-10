@extends('layouts.app')

@section('title', 'Регистрация документа')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <div class="content-hint">У вас имеются сохраненные, но не зарегистрированные документы</div>
            <table class="elements">
                <thead>
                <tr>
                    @foreach($tHeads as $th)
                        <th class="{{ $th['class'] }}" data-field="{{ $th['field'] }}">
                            {{ $th['title'] }}
                            <div class="sorting">
                                <a href="{{ getQueryUrl(['order' => 'asc', 'sort' => $th['field']]) }}"
                                   class="asc {{ implode('-', $sortBy) == $th['field'] . '-asc' ? 'active' : '' }}"></a>
                                <a href="{{ getQueryUrl(['order' => 'desc', 'sort' => $th['field']]) }}"
                                   class="desc {{ implode('-', $sortBy) == $th['field'] . '-desc' ? 'active' : '' }}"></a>
                            </div>
                        </th>
                    @endforeach
                        <th class="w-170">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($documents as $document)
                    <tr data-row="{{ $document->id }}">
                        <td class="light">{{ $document->updated_at->format('d.m.Y в H:i') }}</td>
                        <td>{{ $document->type }}</td>
                        <td>{{ $document->case_nomenclature }}</td>
                        <td>{{ $document->question }}</td>
                        <td>
                            <a class="link" href="{{ route('document.edit', ['document' => $document]) }}">Редактировать</a>
                            <a title="Удалить" class="delete delete-icon modal-link" data-url="{{ route('deleteDocument', ['document' => $document]) }}"></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td></td>
                        <td colspan="3"><p class="text-center">Ничего не найдено</p></td>
                        <td></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <a class="button" href="{{ route('document.add') }}">Зарегистрировать новый документ</a>
        </div>
    </div>
@endsection
