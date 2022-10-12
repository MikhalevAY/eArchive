<h2>Удалить пользователя</h2>
<a class="close"></a>
<form action="{{ route('adm.setState', ['user' => $user->id]) }}">
    @csrf
    <p class="hint">Вы уверены что хотите {{ $state }} данного пользователя?</p>
    <input type="hidden" name="is_active" value="{{ $user->is_active == 1 ? 0 : 1 }}">
    <input type="submit" value="{{ $state }}"/>
    <div class="result center"></div>
</form>
