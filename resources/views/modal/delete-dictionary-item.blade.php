<h2>Удалить элемент справочника</h2>
<a class="close"></a>
<form action="{{ route('dictionary.delete', ['dictionary' => $dictionaryItem]) }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данный элемент?</p>
    <input type="submit" value="Удалить"/>
    <div class="result center"></div>
</form>
