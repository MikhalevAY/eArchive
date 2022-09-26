@extends('layouts.app')

@section('title', 'Журнал логов')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="{{ route('logs') }}" method="get" class="no-ajax">
                <div class="row">
                    <input class="search" placeholder="Автор" type="text" value="{{ request()->input('q') }}" name="q" autocomplete="off" />
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
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="light">{{ $log->created_at->format('d.m.Y в H:i') }}</td>
                            <td>{{ $log->user->surname . ' ' . $log->user->name }}</td>
                            <td>{{ $log->device_ip }}</td>
                            <td>{{ $log->text }}</td>
                            <td>{{ $log->action }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td colspan="2"><p class="text-center">Ничего не найдено</p></td>
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
                            <option @selected($logs->perPage() == 10) value="10">10</option>
                            <option @selected($logs->perPage() == 20) value="20">20</option>
                            <option @selected($logs->perPage() == 50) value="50">50</option>
                            <option @selected($logs->perPage() == 100) value="100">100</option>
                        </select>
                    </div>
                    <div class="pagination right">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
