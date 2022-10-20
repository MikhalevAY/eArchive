@extends('layouts.app')

@section('title', 'Результаты поиска')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top', ['link' => true])
        <div class="wrapper">
            <form action="{{ route('archiveSearchList') }}" method="get" class="no-ajax">
                <div class="row">
                    <h2>@yield('title')</h2>
                    <div class="additional-menu">
                        @if(!adminOrArchivist())
                            <a class="smaller with-text access-request modal-link"
                               data-post="1"
                               data-name="documents"
                               data-url="{{ route('newAccessRequest') }}"
                               data-class="access-request">
                                <i></i>Запросить доступ
                            </a>
                        @endif
                        <a class="smaller with-text export action-with-selected"
                           data-href="{{ route('document.exportSelected') }}"><i></i>Выгрузить в отчет</a>
                        <a title="Скачать выбранные" class="smaller download action-with-selected"
                           data-href="{{ route('document.downloadSelected') }}"><i></i></a>
                        <a title="Удалить выбранные" class="smaller delete modal-link"
                           data-url="{{ route('deleteSelectedDocuments') }}" data-post="1" data-name="documents"><i></i></a>
                    </div>
                </div>
                <table class="elements">
                    <thead>
                    <tr>
                        <th class="width-20">
                            <label class="checkbox">
                                <input class="checkbox-toggle-all" type="checkbox">
                                <div class="checkmark"></div>
                            </label>
                        </th>
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
                        <th class="text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($documents as $document)
                        <tr data-row="{{ $document->id }}" @class(['no-access' => !adminOrArchivist() && $document->is_allowed != 1])>
                            <td>
                                <label class="checkbox">
                                    <input type="checkbox" value="{{ $document->id }}" name="documents[]">
                                    <div class="checkmark"></div>
                                </label>
                            </td>
                            <td class="light">{{ $document->id }}</td>
                            <td>{{ $document->type }}</td>
                            <td>{{ $document->case_nomenclature }}</td>
                            <td>
                                <p class="m-h-95">{{ $document->question }}</p>
                            </td>
                            <td>{{ $document->surname }} {{ $document->name }}</td>
                            <td>{{ $document->created_at->format('d.m.Y') }}</td>
                            <td class="less-padding">
                                @include('components.document-actions', ['document' => $document])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td colspan="6"><p class="text-center">Ничего не найдено</p></td>
                            <td></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <input type="hidden" name="sort" value="{{ $sortBy['sort'] }}">
                <input type="hidden" name="order" value="{{ $sortBy['order'] }}">
                <div class="pagination-row">
                    <div class="per-page">
                        <span>Показывать на странице</span>
                        <select name="per_page">
                            <option @selected($documents->perPage() == 10) value="10">10</option>
                            <option @selected($documents->perPage() == 20) value="20">20</option>
                            <option @selected($documents->perPage() == 50) value="50">50</option>
                            <option @selected($documents->perPage() == 100) value="100">100</option>
                        </select>
                    </div>
                    <div class="pagination right">
                        {{ $documents->appends(request()->query())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
