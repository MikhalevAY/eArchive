<h2>Запросить доступ к документам</h2>
<a class="close"></a>
<form action="{{ route('access-request.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="requested-documents">
        @foreach($documents as $document)
            <div class="doc">
                <div class="name np">{{ $document->type->title }}</div>
                <p class="np">{{ $document->question }}</p>
                <div class="access">
                    <label class="checkbox">
                        <input name="view[{{ $document->id }}]" type="checkbox" value="1" checked>
                        <div class="checkmark"></div>
                        <i>Просмотр</i>
                    </label>
                    <label class="checkbox">
                        <input name="edit[{{ $document->id }}]" type="checkbox" value="1">
                        <div class="checkmark"></div>
                        <i>Редактирование</i>
                    </label>
                    <label class="checkbox">
                        <input name="download[{{ $document->id }}]" type="checkbox" value="1">
                        <div class="checkmark"></div>
                        <i>Скачивание</i>
                    </label>
                    <label class="checkbox">
                        <input name="delete[{{ $document->id }}]" type="checkbox" value="1">
                        <div class="checkmark"></div>
                        <i>Удаление</i>
                    </label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <span class="gray">Комментарий</span>
        <textarea class="no-max-width" name="comment" placeholder="Оставьте комментарий"></textarea>
    </div>
    <div class="buttons">
        <input type="submit" value="Отправить"/>
        <input type="hidden" value="{{ $jsonDocuments }}" name="documents">
        <input type="button" value="Отменить" onClick="closeWindow()" class="no-bg">
    </div>
    <div class="result"></div>
</form>
