<h2>Удалить выбранных пользователей</h2>
<a class="close"></a>
<form class="close-after" action="{{ route('adm.deleteSelected') }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данных пользователей?</p>
    <input type="hidden" name="users" value="{{ $users }}">
    <input type="submit" value="Удалить"/>
</form>
