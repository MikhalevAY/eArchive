<h2>Сбросить пароль</h2>
<a class="close"></a>
<form action="{{ route('adm.resetPassword', ['user' => $user->id]) }}" method="post">
    @csrf
    <p class="hint">Вы уверены что хотите сбросить пароль данному пользователю?</p>
    <input type="submit" value="Сбросить пароль"/>
    <div class="result center"></div>
</form>
