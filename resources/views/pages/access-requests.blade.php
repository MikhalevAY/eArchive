@extends('layouts.app')

@section('title', 'Запросы')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="{{ route('accessRequests') }}" method="get" class="no-ajax">
                <div class="row with-reset">
                    <input class="inline-block" placeholder="Автор" type="text" value="{{ request()->input('q') }}" name="q" autocomplete="off" />
                    <input type="submit" value="" class="search">
                    <input @class(['visible' => $showResetButton, 'reset-row-inputs' => true]) type="button" value="">
                </div>
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
                            <th>Запрашиваемые документы</th>
                            <th>Причина</th>
                            <th class="text-center">Статус</th>
                            <th class="w-140 text-center">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td class="light">{{ $request->created_at->format('d.m.Y') }}</td>
                            <td>{{ $request->full_name }}</td>
                            <td>
                                {{ $request->document_accesses_count }} документ{{ getEnding($request->document_accesses_count, ['', 'а', 'ов']) }}
                            </td>
                            <td>{{ mb_substr($request->comment, 0, 100, 'utf8') }}</td>
                            <td class="text-center">
                                <span class="status {{ $request->status }}">{{ $statusTitle[$request->status] }}</span>
                            </td>
                            <td class="text-center">
                                <a class="modal-link button"
                                   data-class="access-request"
                                   data-url="{{ route('editAccessRequest', ['accessRequest' => $request->id]) }}">Посмотреть</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td colspan="4"><p class="text-center">Ничего не найдено</p></td>
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
                            <option @selected($requests->perPage() == 10) value="10">10</option>
                            <option @selected($requests->perPage() == 20) value="20">20</option>
                            <option @selected($requests->perPage() == 50) value="50">50</option>
                            <option @selected($requests->perPage() == 100) value="100">100</option>
                        </select>
                    </div>
                    <div class="pagination right">
                        {{ $requests->appends(request()->query())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
