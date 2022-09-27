<h2>Удалить Документ</h2>
<a class="close"></a>
<form action="{{ route('document.delete', ['document' => $document->id]) }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данный документ?</p>
    <input type="submit" value="Удалить"/>
    <div class="result center"></div>
</form>
