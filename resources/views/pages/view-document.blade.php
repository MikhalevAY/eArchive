@extends('layouts.app')

@section('title', $dictionaries[$document->type_id])

@section('content')
    @include('layouts.menu')
    <div class="col-content">
        @include('layouts.content-top', ['link' => true])
        <div class="wrapper">
            <div class="document-detailed">
                <h2>@yield('title')</h2>
                <div class="action-links">
                    <a class="print {{ var_export($actions['view']) }}"
                       @if($actions['view']) href="{{ route('document.print', ['document' => $document]) }}"
                       target="_blank" @endif></a>
                    <a class="edit {{ var_export($actions['edit']) }}"
                       @if($actions['edit']) href="{{ route('document.edit', ['document' => $document]) }}" @endif></a>
                    <a class="download {{ var_export($actions['download']) }}"
                       @if($actions['download']) href="{{ route('document.download', ['document' => $document]) }}" @endif></a>
                    <a class="modal-link delete {{ var_export($actions['delete']) }}"
                       @if($actions['delete']) data-url="{{ route('deleteDocument', ['document' => $document]) }}" @endif></a>
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
                            <td>Отправитель
                                <span>{{ $document->sender_id ? $dictionaries[$document->sender_id] : '' }}</span>
                            </td>
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
                            <td>Получатель
                                <span>{{ $document->receiver_id ? $dictionaries[$document->receiver_id] : '' }}</span>
                            </td>
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
                <div class="document-text collapsed">
                    <p>{!! nl2br($document->text) !!}</p>
                </div>
                <a class="show-full-text collapse">Развернуть</a>
                <a class="show-full-text">Свернуть</a>

                <div class="divider"></div>
                <div class="files">
                    @if($actions['download'])
                        <a class="download-archive" href="{{ route('document.download', ['document' => $document]) }}">Скачать
                            архив</a>
                    @endif
                    <h5>Основной документ</h5>
                    <div class="list">
                        <div class="file-block {{ $document->file_extension }}">
                            <span>{{ $document->file_name }}</span>
                            <b>{{ $document->file_size }} Mb</b>
                            <div>
                                <a href="{{ $document->downloadLink() }}">Скачать</a>
                            </div>
                        </div>
                    </div>
                    <h5>Вложения к документу</h5>
                    <div class="list">
                        @foreach($document->attachments as $attachment)
                            <div class="file-block {{ $attachment->extension }}">
                                <span>{{ $attachment->name }}</span>
                                <b>{{ $attachment->size }} Mb</b>
                                <div>
                                    <a href="{{ $attachment->downloadLink() }}">Скачать</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
