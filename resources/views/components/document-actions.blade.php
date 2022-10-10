@if(adminOrArchivist() || $document->is_allowed == 1)
    <div class="actions-menu">
        <div class="submenu">
            @if($document->view == 1 || adminOrArchivist())
                <a class="view" href="{{ route('document.view', ['document' => $document]) }}">Открыть</a>
                <a class="print" href="{{ route('document.print', ['document' => $document]) }}" target="_blank">Распечатать</a>
            @endif
            @if($document->edit == 1 || adminOrArchivist())
                <a class="edit" href="{{ route('document.edit', ['document' => $document]) }}">Редактировать</a>
            @endif
            @if($document->download == 1 || adminOrArchivist())
                <a href="{{ route('document.download', ['document' => $document]) }}" class="download">Скачать</a>
            @endif
            @if($document->delete == 1 || adminOrArchivist())
                <a class="modal-link delete" data-url="{{ route('deleteDocument', ['document' => $document]) }}">Удалить</a>
            @endif
        </div>
    </div>
@else
    @if(is_null($document->is_allowed))
        <a class="button modal-link" data-class="access-request" data-url="{{ route('newAccessRequest', ['document' => $document]) }}">Запросить</a>
    @else($document->is_allowed == 0)
        <span class="status closed">Доступ запрещён</span>
    @endif
@endif
