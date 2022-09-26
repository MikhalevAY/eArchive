@extends('layouts.app')

@section('title', 'Читальный зал')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>
                @yield('title')
                <a class="modal-link right" data-url="{{ route('searchAvailableDocuments') }}" data-class="search-documents">Найти документ</a>
            </h2>
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
                        <th class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($documents as $log)
                    <tr>
                        <td class="light">{{ $log->created_at->format('d.m.Y в H:i') }}</td>
                        <td>{{ $log->user->surname . ' ' . $log->user->name }}</td>
                        <td>{{ $log->device_ip }}</td>
                        <td>{{ $log->text }}</td>
                        <td>{{ $log->action }}</td>
                        <td>
                            <div class="actions-menu">
                                <div class="submenu">
                                    <a class="modal-link edit" data-url="{{ route('editUser', ['user' => $user->id]) }}">Редактировать</a>
                                    <a class="modal-link reset-password" data-url="{{ route('resetPassword', ['user' => $user->id]) }}">Сбросить пароль</a>
                                    <a class="modal-link delete" data-url="{{ route('deleteUser', ['user' => $user->id]) }}">Удалить</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="actions-menu">
                                <div class="submenu">
                                    <a class="modal-link edit" data-url="{{ route('editUser', ['user' => $user->id]) }}">Редактировать</a>
                                    <a class="modal-link reset-password" data-url="{{ route('resetPassword', ['user' => $user->id]) }}">Сбросить пароль</a>
                                    <a class="modal-link delete" data-url="{{ route('deleteUser', ['user' => $user->id]) }}">Удалить</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td></td>
                        <td colspan="5"><p class="text-center">Ничего не найдено</p></td>
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
{{--                    <select name="per_page">--}}
{{--                        <option @selected($documents->perPage() == 10) value="10">10</option>--}}
{{--                        <option @selected($documents->perPage() == 20) value="20">20</option>--}}
{{--                        <option @selected($documents->perPage() == 50) value="50">50</option>--}}
{{--                        <option @selected($documents->perPage() == 100) value="100">100</option>--}}
{{--                    </select>--}}
                </div>
                <div class="pagination right">
{{--                    {{ $documents->appends(request()->query())->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
