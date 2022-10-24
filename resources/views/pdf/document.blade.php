<style type="text/css">
    * {
        margin: 0;
        padding: 0;
    }

    .divider {
        height: 1px;
        background: #E3E4EB;
        margin: 20px 0 21px;
    }

    h2 {
        font-weight: bold;
        font-size: 12px;
        color: #111;
        margin-bottom: 26px;
        text-transform: uppercase;
    }

    h3 {
        font-weight: normal;
        font-size: 15px;
    }

    span {
        font-size: 11px;
        color: #6D6D6D;
        text-transform: uppercase;
        display: block;
    }

    p {
        font-size: 14px;
        color: #000;
        line-height: 24px;
        margin-top: 3px;
    }

    .col-4 {
        width: 100%;
    }

    .col-4 div {
        width: 25%;
        float: left;
    }

    .col-4 .margin-top {
        margin-top: 10px;
    }

    .col-2 {
        width: 100%;
        margin-top: 10px;
    }

    .col-3 {
        width: 100%;
    }

    .w-75 {
        width: 75%;
        float: left;
    }

    .w-50 {
        width: 50%;
        float: left;
    }

    .w-25 {
        width: 25%;
        float: left;
    }

    .text {
        margin-top: 10px;
    }

    .row {
        margin-top: 10px;
    }

    .checkbox {
        width: 10px;
        height: 10px;
        background: #CCC;
        color: #FFF;
        border-radius: 6px;
        float: left;
        padding: 6px;
        font-size: 0.1px;
        box-sizing: border-box;
        text-align: center;
    }

    .checkbox div {
        width: 10px;
        height: 10px;
        border-radius: 2px;
        background: #FFF;
    }

    .label {
        float: left;
        line-height: 22px;
        padding-left: 10px;
        font-size: 14px;
    }
</style>

<div class="col-3">
    <div class="w-25">
        <h3>{{ $document->type->title }}</h3>
    </div>
    <div class="w-25">
        <h3>{{ $document->caseNomenclature->title }}</h3>
    </div>
    <div class="w-50">
        <h3>{{ $document->question }}</h3>
    </div>
</div>
<div class="divider"></div>
<h2>Информация об отправителе</h2>
<div class="col-4">
    <div>
        <span>Отправитель</span>
        <p>{{ $document->sender?->title }}</p>
    </div>
    <div>
        <span>Исходящий номер</span>
        <p>{{ $document->outgoing_number }}</p>
    </div>
    <div>
        <span>Исходящая дата</span>
        <p>{{ $document->outgoing_date?->format('d.m.Y') }}</p>
    </div>
    <div>
        <span>ФИО регистрирующего</span>
        <p>{{ $document->author->full_name }}</p>
    </div>
</div>

<div class="divider"></div>
<h2>Информация о получателе</h2>
<div class="col-4">
    <div>
        <span>Получатель</span>
        <p>{{ $document->receiver?->title }}</p>
    </div>
    <div>
        <span>Входящий номер</span>
        <p>{{ $document->income_number }}</p>
    </div>
    <div>
        <span>Дата регистрации</span>
        <p>{{ $document->registration_date?->format('d.m.Y') }}</p>
    </div>
    <div>
        <span>Время регистрации</span>
        <p>{{ $document->registration_time?->format('H:i') }}</p>
    </div>
    <div class="margin-top">
        <span>Адресат</span>
        <p>{{ $document->addressee }}</p>
    </div>
</div>

<div class="divider"></div>
<h2>Общая информация</h2>
<div class="col-4">
    <div>
        <span>Способ доставки</span>
        <p>{{ $document->deliveryType?->title }}</p>
    </div>
    <div>
        <span>Кол-во экземпляров</span>
        <p>{{ $document->number_of_sheets }}</p>
    </div>
    <div>
        <span>Язык обращения</span>
        <p>{{ $document->language?->title }}</p>
    </div>
    <div>
        <span>Срок хранения</span>
        <p>{{ $document->shelf_life }}</p>
    </div>
    <div class="margin-top">
        <span>Ответное на:</span>
        <p>{{ $document->answer_to_number }} {{ $document->answer_to_date?->format('от d.m.Y') }}</p>
    </div>
</div>
<div class="col-2">
    <div class="w-25">
        <span>ФИО исполнителя</span>
        <p>{{ $document->performer }}</p>
    </div>
    <div class="w-75">
        <span>Примечание</span>
        <p>{{ $document->note }}</p>
    </div>
</div>

@if($document->gr_document)
    <div class="row">
        <div class="checkbox">
            <div></div>
        </div>
        <div class="label">GR-документ</div>
    </div>
@endif
