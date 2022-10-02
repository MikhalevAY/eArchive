<h2 class="with-status">
    Запрос
    <span class="status {{ $accessRequest->status }}">{{ $statusTitle[$accessRequest->status] }}</span>
</h2>
<a class="close"></a>
<form action="{{ route('access-request.update', ['accessRequest' => $accessRequest->id]) }}" method="post">
    @csrf
    <div class="col-3">
        <div class="row">
            <span class="gray">Дата</span>
            <p>{{ $accessRequest->created_at->format('d.m.Y') }}</p>
        </div>
        <div class="row">
            <span class="gray">Автор</span>
            <p>{{ $accessRequest->author }}</p>
        </div>
        <div class="row"></div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <span class="gray">Запрашиваемые документы</span>
        <div class="requested-documents">
        @foreach($accessRequest->documents as $document)
            <div class="doc {{ $document->pivot->is_allowed == 1 ? 'allowed' : 'forbidden' }}">
                <div class="name">{{ $document->type->title }}</div>
                <p>{{ $document->question }}</p>
                @if($accessRequest->status != 'closed')
                <input class="no-bg toggle-doc-access" type="button" data-allow="Разрешить" data-forbid="Отклонить" value="Отклонить">
                <input type="hidden" name="document-{{ $document->id }}" value="1">
                @endif
                <div class="access">
                    <div class="access-element">
                        <div class="circle {{ $document->pivot->view == 1 ? 'checked' : '' }}"></div>
                        <i>Просмотр</i>
                    </div>
                    <div class="access-element">
                        <div class="circle {{ $document->pivot->edit == 1 ? 'checked' : '' }}"></div>
                        <i>Редактирование</i>
                    </div>
                    <div class="access-element">
                        <div class="circle {{ $document->pivot->download == 1 ? 'checked' : '' }}"></div>
                        <i>Скачивание</i>
                    </div>
                    <div class="access-element">
                        <div class="circle {{ $document->pivot->delete == 1 ? 'checked' : '' }}"></div>
                        <i>Удаление</i>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <span class="gray">Комментарий к запросу</span>
        <p>{{ $accessRequest->comment }}</p>
    </div>
    @if($accessRequest->status != 'closed')
    <div class="buttons">
        <input type="submit" value="Подтвердить"/>
        <input type="button" value="Отменить" onClick="closeWindow()" class="no-bg">
    </div>
    <div class="result"></div>
    @endif
</form>
