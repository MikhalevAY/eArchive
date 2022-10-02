@extends('layouts.app')

@section('title', 'Регистрация документа')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="document-form">
                @csrf
                <div class="col-2">
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
                <div class="divider m-t-15"></div>

                <h3>Информация об отправителе</h3>
                <div class="col-1">
                    <div class="row">
                        <span>Отправитель</span>
                        <select class="no-max-width" name="sender_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['counterparty'] as $counterparty)
                                <option value="{{ $counterparty->id }}">{{ $counterparty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Исходящий номер</span>
                        <input class="no-max-width" type="text" name="outgoing_number" placeholder="Исходящий номер" autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Исходящая дата</span>
                        <input class="date no-max-width" type="text" name="outgoing_date" placeholder="Исходящая дата" autocomplete="off" />
                    </div>
                </div>
                <div class="divider m-t-15"></div>

                <h3>Информация о получателе</h3>
                <div class="col-1">
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
                <div class="col-3">
                    <div class="row">
                        <span>Входящий номер</span>
                        <input class="no-max-width" type="text" name="income_number" placeholder="Входящий номер" autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Дата регистрации</span>
                        <input class="date no-max-width" type="text" name="registration_date" placeholder="Дата регистрации " autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Время регистрации</span>
                        <input class="time no-max-width" type="text" name="registration_time" placeholder="Время регистрации" autocomplete="off" />
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
                <div class="divider m-t-15"></div>

                <h3>Общая информация</h3>
                <div class="col-3">
                    <div class="row">
                        <span>Способ доставки</span>
                        <select class="no-max-width" name="delivery_type_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['delivery_type'] as $deliveryType)
                                <option value="{{ $deliveryType->id }}">{{ $deliveryType->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>Кол-во листов/экземпляров</span>
                        <input class="no-max-width" type="text" name="number_of_sheets" placeholder="Укажите количество " autocomplete="off" />
                    </div>
                    <div class="row">
                        <span>Язык обращения</span>
                        <select class="no-max-width" name="language_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['language'] as $language)
                                <option value="{{ $language->id }}">{{ $language->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="row">
                        <span>Содержание</span>
                        <textarea class="no-max-width" name="summary" placeholder="Содержание"></textarea>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Срок хранения</span>
                        <select name="shelf_life">
                            <option value="">Не выбрано</option>
                            @foreach($shelfLife as $k => $time)
                                <option value="{{ $k }}">{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>ФИО исполнителя</span>
                        <input class="no-max-width" type="text" name="performer" placeholder="ФИО исполнителя" autocomplete="off" />
                    </div>
                </div>
                <div class="col-1">
                    <div class="row">
                        <span>Примечание</span>
                        <input class="no-max-width" type="text" name="note" placeholder="Примечание" autocomplete="off" />
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <div class="col-2">
                            <div class="row">
                                <span>Ответное на:</span>
                                <input class="no-max-width" type="text" name="answer_to_number" placeholder="Укажите номер" autocomplete="off" />
                            </div>
                            <div class="row">
                                <span>&nbsp;</span>
                                <input class="date no-max-width" type="text" name="answer_to_date" placeholder="Дата" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="checkbox">
                            <input value="1" name="gr_document" type="checkbox">
                            <div class="checkmark"></div>
                            <i>GR-документ</i>
                        </label>
                        <div class="label-hint max-500">Корреспондент входит в список государственных органов GR-список, включенный в базу «Справочники»</div>
                    </div>
                </div>
                <div class="divider m-t-15"></div>


                <h3>Документы</h3>
                <div class="row">
                    <span>Основной документ</span>
                    <label class="file-label no-max-width" for="file">
                        <div><i class="file-name">Выберите файл</i></div>
                        <input class="file-input" id="file" type="file" name="file">
                    </label>
                </div>
                <div class="row">
                    <span>Вложения к документу</span>
                    <label class="file-label no-max-width" for="attachments">
                        <div><i class="file-name">Выберите файлы</i></div>
                        <input class="file-input" id="attachments" type="file" name="attachments[]" multiple>
                    </label>
                </div>
                <div class="divider m-t-15"></div>

                <div class="col-1 m-b-15">
                    <div class="row">
                        <span>История согласования/исполнения</span>
                        <textarea class="no-max-width" name="history" placeholder="История всех действий пользователей с объектом"></textarea>
                    </div>
                </div>

                <div class="col-1 m-b-15">
                    <div class="row">
                        <label class="checkbox">
                            <input class="checkbox-toggle-all" name="available_for_all" type="checkbox">
                            <div class="checkmark"></div>
                            <i>Доступен всем</i>
                        </label>
                    </div>
                </div>

                <input type="hidden" name="is_draft" value="0">
                <input type="button" value="Зарегистрировать" class="submit-button register-document">
                <input type="button" value="Сохранить" class="no-bg save-document">
                <input type="button" value="Отменить" class="no-bg cancel"/>
                <div class="result"></div>
            </form>
        </div>
    </div>
@endsection
