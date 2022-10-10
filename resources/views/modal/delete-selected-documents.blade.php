<h2>Удалить выбранные документы</h2>
<a class="close"></a>
<form action="{{ route('document.deleteSelected') }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данные документы?</p>
    <input type="hidden" name="documents" value="{{ $documents }}">
    <input type="submit" value="Удалить"/>
    <div class="result center"></div>
</form>
