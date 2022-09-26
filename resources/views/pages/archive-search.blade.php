@extends('layouts.app')

@section('title', 'Поиск в архиве')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="" method="get" class="no-ajax">
                <div class="col-2 m-b-15">
                    <div class="row">
                        <span>Тип документа</span>
                        <select class="no-max-width" name="document_type_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['document_type'] as $documentType)
                                <option value="{{ $documentType->id }}">{{ $documentType->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>Номенклатура дел</span>
                        <select class="no-max-width" name="case_nomenclature_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['case_nomenclature'] as $nomenclature)
                                <option value="{{ $nomenclature->id }}">{{ $nomenclature->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2 m-b-15">
                    <div class="row">
                        <span>Отправитель</span>
                        <select class="no-max-width" name="sender_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['counterparty'] as $counterparty)
                                <option value="{{ $counterparty->id }}">{{ $counterparty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>Получатель</span>
                        <select class="no-max-width" name="receiver_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['counterparty'] as $counterparty)
                                <option value="{{ $counterparty->id }}">{{ $counterparty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Адресат</span>
                        <input class="no-max-width" type="text" name="addressee" placeholder="ФИО" autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Характер вопроса</span>
                        <input class="no-max-width" type="text" name="question" placeholder="Характер вопроса" autocomplete="off" />
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <span>ID документа</span>
                        <input class="no-max-width" type="text" name="id" placeholder="ID документа" autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Номер документа</span>
                        <input class="no-max-width" type="text" name="income_number" placeholder="Номер документа" autocomplete="off" />
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="row">
                                <span>Дата</span>
                                <input class="date no-max-width" type="text" name="registration_date" placeholder="От" autocomplete="off" />
                            </div>
                            <div class="row">
                                <span>&nbsp;</span>
                                <input class="date no-max-width" type="text" name="registration_date" placeholder="До" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-1 m-b-15">
                    <div class="row">
                        <span>Текст</span>
                        <textarea class="no-max-width" name="document_text" placeholder="Введите текст"></textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="checkbox">
                        <input class="checkbox-toggle-all" name="gr_document" type="checkbox">
                        <div class="checkmark"></div>
                        <i>GR-документ</i>
                    </label>
                    <div class="label-hint">Корреспондент входит в список государственных органов GR-список, включенный в базу «Справочники»</div>
                </div>
                <input type="submit" value="Найти"/>
                <div class="result text-center"></div>
            </form>
        </div>
    </div>
@endsection
