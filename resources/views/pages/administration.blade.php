@extends('layouts.app')

@section('title', 'Администрирование')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>
                @yield('title')
                <a class="modal-link right" data-url="{{ route('addUser') }}">Добавить пользователя</a>
            </h2>
            <form action="{{ route('administration') }}" method="get" class="no-ajax">
                <div class="row with-reset">
                    <input class="inline-block" placeholder="Фамилия, имя или отчество" type="text" value="{{ request()->input('q') }}" name="q" autocomplete="off" />
                    <input type="submit" value="" class="search">
                    <input @class(['visible' => $showResetButton, 'reset-row-inputs' => true]) type="button" value="">

                    <div class="delete-selected">
                        <a class="delete modal-link" data-url="{{ route('deleteSelectedUsers') }}" data-checkboxes="elements"><i></i></a>
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
                    @forelse($users as $user)
                        <tr data-row="{{ $user->id }}">
                            <td>
                                <label class="checkbox">
                                    <input type="checkbox" value="{{ $user->id }}" name="elements[]">
                                    <div class="checkmark"></div>
                                </label>
                            </td>
                            <td class="light">{{ $user->id }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->name . ' ' . $user->patronymic }}</td>
                            <td>{{ $roleTitles[$user->role] }}</td>
                            <td class="text-center">{{ $user->created_at->format('d.m.Y в H:i') }}</td>
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
                        <select name="per_page">
                            <option @selected($users->perPage() == 10) value="10">10</option>
                            <option @selected($users->perPage() == 20) value="20">20</option>
                            <option @selected($users->perPage() == 50) value="50">50</option>
                            <option @selected($users->perPage() == 100) value="100">100</option>
                        </select>
                    </div>
                    <div class="pagination right">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
