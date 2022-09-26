<h2>Сменить пароль</h2>
<a class="close"></a>
<form action="{{ route('updatePersonalPassword') }}" method="post">
    @csrf
    <div class="row">
        <span>Текущий пароль</span>
        <input type="password" name="password" placeholder="Ваш пароль" autocomplete="off" />
        <div class="eye"></div>
    </div>
    <div class="row">
        <span>Новый пароль</span>
        <input type="password" name="new_password" placeholder="Придумайте пароль" autocomplete="off"/>
        <div class="eye"></div>
    </div>
    <div class="row">
        <span>Повторите пароль</span>
        <input type="password" name="repeat_password" placeholder="Повторите пароль" autocomplete="off"/>
        <div class="eye"></div>
    </div>
    <input type="submit" value="Сохранить"/>
    <div class="result center"></div>
</form>
