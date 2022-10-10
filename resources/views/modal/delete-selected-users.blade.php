<h2>Удалить выбранных пользователей</h2>
<a class="close"></a>
<form action="{{ route('adm.deleteSelectedUsers') }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данных пользователей?</p>
    <input type="hidden" name="users" value="{{ $users }}">
    <input type="submit" value="Удалить"/>
    <div class="result center"></div>
</form>
