@extends('layouts.app')

@section('title', 'Редактирование')

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top')
        <div class="wrapper">
            <h2>@yield('title')</h2>
            <form action="{{ route('document.update', ['document' => $document]) }}" method="post"
                  enctype="multipart/form-data" id="document-form">
                @csrf
                <div class="col-2">
                    <div class="row">
                        <span>Тип документа</span>
                        <select class="no-max-width" name="type_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['document_type'] as $type)
                                <option
                                    @selected($type->id == $document['type_id']) value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>Номенклатура дел</span>
                        <select class="no-max-width" name="case_nomenclature_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['case_nomenclature'] as $nomenclature)
                                <option
                                    @selected($nomenclature->id == $document['case_nomenclature_id']) value="{{ $nomenclature->id }}">{{ $nomenclature->title }}</option>
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
                                <option
                                    @selected($counterparty->id == $document['sender_id']) value="{{ $counterparty->id }}">{{ $counterparty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Исходящий номер</span>
                        <input value="{{ $document->outgoing_number }}" class="no-max-width" type="text"
                               name="outgoing_number" placeholder="Исходящий номер" autocomplete="off"/>
                    </div>
                    <div class="row">
                        <span>Исходящая дата</span>
                        <input value="{{ $document->outgoing_date?->format('Y-m-d') }}" class="date no-max-width"
                               type="text" name="outgoing_date" placeholder="Исходящая дата" autocomplete="off"/>
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
                                <option
                                    @selected($counterparty->id == $document['receiver_id']) value="{{ $counterparty->id }}">{{ $counterparty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <span>Входящий номер</span>
                        <input value="{{ $document->income_number }}" class="no-max-width" type="text"
                               name="income_number" placeholder="Входящий номер" autocomplete="off"/>
                    </div>
                    <div class="row">
                        <span>Дата регистрации</span>
                        <input value="{{ $document->registration_date?->format('Y-m-d') }}" class="date no-max-width"
                               type="text" name="registration_date" placeholder="Дата регистрации " autocomplete="off"/>
                    </div>
                    <div class="row">
                        <span>Время регистрации</span>
                        <input value="{{ $document->registration_time?->format('H:i') }}" class="time no-max-width"
                               type="text" name="registration_time" placeholder="Время регистрации" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Адресат</span>
                        <input value="{{ $document->addressee }}" class="no-max-width" type="text" name="addressee"
                               placeholder="ФИО" autocomplete="off"/>
                    </div>
                    <div class="row">
                        <span>Характер вопроса</span>
                        <input value="{{ $document->question }}" class="no-max-width" type="text" name="question"
                               placeholder="Характер вопроса" autocomplete="off"/>
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
                                <option
                                    @selected($deliveryType->id == $document['delivery_type_id']) value="{{ $deliveryType->id }}">{{ $deliveryType->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>Кол-во листов/экземпляров</span>
                        <input value="{{ $document->number_of_sheets }}" class="no-max-width" type="text"
                               name="number_of_sheets" placeholder="Укажите количество " autocomplete="off"/>
                    </div>
                    <div class="row">
                        <span>Язык обращения</span>
                        <select class="no-max-width" name="language_id">
                            <option value="">Выберите</option>
                            @foreach($dictionaries['language'] as $language)
                                <option
                                    @selected($language->id == $document['language_id']) value="{{ $language->id }}">{{ $language->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="row">
                        <span>Содержание</span>
                        <textarea class="no-max-width" name="summary"
                                  placeholder="Содержание">{{ $document->summary }}</textarea>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <span>Срок хранения</span>
                        <select name="shelf_life">
                            <option value="">Не выбрано</option>
                            @foreach($shelfLife as $k => $time)
                                <option @selected($k == $document['shelf_life']) value="{{ $k }}">{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <span>ФИО исполнителя</span>
                        <input value="{{ $document->performer }}" class="no-max-width" type="text" name="performer"
                               placeholder="ФИО исполнителя" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-1">
                    <div class="row">
                        <span>Примечание</span>
                        <input value="{{ $document->note }}" class="no-max-width" type="text" name="note"
                               placeholder="Примечание" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <div class="col-2">
                            <div class="row">
                                <span>Ответное на:</span>
                                <input value="{{ $document->answer_to_number }}" class="no-max-width" type="text"
                                       name="answer_to_number" placeholder="Укажите номер" autocomplete="off"/>
                            </div>
                            <div class="row">
                                <span>&nbsp;</span>
                                <input value="{{ $document->answer_to_date?->format('Y-m-d') }}"
                                       class="date no-max-width" type="text" name="answer_to_date" placeholder="Дата"
                                       autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="checkbox">
                            <input type="hidden" name="gr_document" value="0"/>
                            <input value="1" name="gr_document" type="checkbox" @checked($document->gr_document)>
                            <div class="checkmark"></div>
                            <i>GR-документ</i>
                        </label>
                        <div class="label-hint max-500">Корреспондент входит в список государственных органов GR-список,
                            включенный в базу «Справочники»
                        </div>
                    </div>
                </div>
                <div class="divider m-t-15"></div>


                <h3>Документы</h3>
                <div class="row">
                    <span>Основной документ</span>
                    <div class="file-block">
                        <div class="uploaded-file no-max-width">
                            <div class="file-img {{ $document['file_extension'] }}"></div>
                            <div class="info">
                                <h3>{{ $document['file_name'] }}</h3>
                                {{ $document['file_size'] }} Mb
                            </div>
                            <a class="delete delete-file"></a>
                        </div>
                        <label class="file-label hidden no-max-width" for="file" data-deleted="file_deleted">
                            <div><i class="file-name">Выберите файл</i></div>
                            <input type="hidden" name="file_deleted">
                            <input class="file-input" id="file" type="file" name="file">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <span>Вложения к документу</span>
                    @if(!$document->attachments->isEmpty())
                        <div class="attachments">
                            @foreach($document->attachments as $attachment)
                                <div class="attachment">
                                    <div class="file-img {{ $attachment->extension }}"></div>
                                    <div class="info">
                                        <h3>{{ $attachment['name'] }}</h3>
                                        {{ $attachment['size'] }} Mb
                                    </div>
                                    <a class="delete delete-attachment"></a>
                                    <input class="hidden" type="checkbox" name="attachments_deleted[]"
                                           value="{{ $attachment->id}}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <label class="file-label no-max-width" for="multiple-file">
                        <div><i data-text="Выберите файлы" class="file-name">Выберите файлы</i></div>
                        <input class="file-input" id="multiple-file" type="file" name="multiple-file[]" multiple>
                    </label>
                    <div class="attachments new-attachments"></div>
                </div>
                <div class="divider m-t-15"></div>

                <div class="col-1 m-b-15">
                    <div class="row">
                        <span>История согласования/исполнения</span>
                        <textarea class="no-max-width" name="history"
                                  placeholder="История всех действий пользователей с объектом">{{ $document->history }}</textarea>
                    </div>
                </div>

                <input type="hidden" name="is_draft" value="0">
                <input type="button" value="Сохранить" class="submit-button register-document">
                <input type="button" value="Отменить" class="no-bg cancel"/>
                <div class="result"></div>
            </form>
        </div>
    </div>
@endsection
