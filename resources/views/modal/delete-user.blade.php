<h2>Удалить пользователя</h2>
<a class="close"></a>
<form class="close-after" action="{{ route('adm.delete', ['user' => $user->id]) }}">
    @method('delete')
    @csrf
    <p class="hint">Вы уверены что хотите удалить данного пользователя?</p>
    <input type="submit" value="Удалить"/>
</form>
