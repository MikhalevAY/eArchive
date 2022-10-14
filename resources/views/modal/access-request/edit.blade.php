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
            @foreach($accessRequest->documentAccesses as $documentAccess)
                <div class="doc {{ $documentAccess->is_allowed === 0  ? 'forbidden' : 'allowed' }}">
                    <div class="name">{{ $documentAccess->document->type?->title }}</div>
                    <p>{{ $documentAccess->document->question }}</p>
                    @if($accessRequest->status != 'closed')
                        <input class="no-bg toggle-doc-access" type="button" data-allow="Разрешить"
                               data-forbid="Отклонить" value="Отклонить">
                        <input type="hidden" name="document-{{ $documentAccess->document_id }}" value="1">
                    @endif
                    <div class="access">
                        <div class="access-element">
                            <div class="circle {{ $documentAccess->view == 1 ? 'checked' : '' }}"></div>
                            <i>Просмотр</i>
                        </div>
                        <div class="access-element">
                            <div class="circle {{ $documentAccess->edit == 1 ? 'checked' : '' }}"></div>
                            <i>Редактирование</i>
                        </div>
                        <div class="access-element">
                            <div class="circle {{ $documentAccess->download == 1 ? 'checked' : '' }}"></div>
                            <i>Скачивание</i>
                        </div>
                        <div class="access-element">
                            <div class="circle {{ $documentAccess->delete == 1 ? 'checked' : '' }}"></div>
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
