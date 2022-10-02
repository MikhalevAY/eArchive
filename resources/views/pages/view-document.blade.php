@extends('layouts.app')

@section('title', $dictionaries[$document->document_type_id])

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top', ['link' => true])
        <div class="wrapper">
            <div class="document-detailed">
                <h2>@yield('title')</h2>
                <div class="action-links">
                    @foreach($actions as $class => $access)
                        <a class="{{ $class }} {{ var_export($access) }}" @if($access) href="#" @endif></a>
                    @endforeach
                </div>
                <p>{{ $document->question }}</p>
                <div class="document-info">
                    <a class="toggle-link close">Свернуть</a>
                    <a class="toggle-link open">Развернуть</a>
                    <table>
                        <tr>
                            <td>Автор <span>{{ $document->author->surname }} {{ $document->author->name }}</span></td>
                            <td>Рег. номер <span>{{ $document->id }}</span></td>
                            <td>Номенклатура <span>{{ $dictionaries[$document->case_nomenclature_id] }}</span></td>
                            <td>Срок хранения <span>{{ $shelfLife[$document->shelf_life] }}</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Отправитель <span>{{ $dictionaries[$document->sender_id] }}</span></td>
                            <td>Исход. номер <span>{{ $document->outgoing_number }}</span></td>
                            <td>исход. дата
                                <span>
                                    @if(!is_null($document->outgoing_date)) {{ $document->outgoing_date->format('d.m.Y') }} @endif
                                </span>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Получатель <span>{{ $dictionaries[$document->receiver_id] }}</span></td>
                            <td>Вход. номер <span>{{ $document->income_number }}</span></td>
                            <td>Дата рег. <span>{{ $document->registration_date->format('d.m.Y') }}</span></td>
                            <td>Время рег. <span>{{ $document->registration_time->format('H:i') }}</span></td>
                            <td>Адресат <span>{{ $document->addressee }}</span></td>
                        </tr>
                        <tr>
                            <td>Ответное на
                                <span>
                                    {{ $document->answer_to_number }}
                                    @if(!is_null($document->answer_to_date)) {{ $document->answer_to_date->format('d.m.Y') }} @endif
                                </span>
                            </td>
                            <td colspan="4">Примечание <span>{{ $document->note }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="document-text">
                    <p>{!! nl2br($document->document_text) !!}</p>
                </div>

                <div class="divider"></div>
                <div class="files">
                    <a class="download-archive">Скачать архив</a>
                    <h5>Основной документ</h5>
                    <div class="list">
                        <div class="file-block">
                            <span>{{ $document->file_name }}</span>
                            <b>{{ $document->file_size }} Mb</b>
                            <div>
                                <a href="#">Открыть</a>
                                <a href="#">Скачать</a>
                            </div>
                        </div>
                    </div>
                    <h5>Вложения к документу</h5>
                    <div class="list">
                    @foreach($document->attachments as $attachment)
                            <div class="file-block">
                                <span>{{ $attachment->name }}</span>
                                <b>{{ $attachment->size }} Mb</b>
                                <div>
                                    <a href="#">Открыть</a>
                                    <a href="#">Скачать</a>
                                </div>
                            </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
