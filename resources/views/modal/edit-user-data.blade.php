<h2>Редактировать данные</h2>
<a class="close"></a>
<form action="{{ route('adm.updateUser', ['user' => $user->id]) }}" method="post">
    @csrf
    <div class="row">
        <span>Фамилия</span>
        <input type="text" name="surname" placeholder="Фамилия" value="{{ $user->surname }}" autocomplete="off" />
    </div>
    <div class="row">
        <span>Имя</span>
        <input type="text" name="name" placeholder="Имя" value="{{ $user->name }}" autocomplete="off"/>
    </div>
    <div class="row">
        <span>Отчество</span>
        <input type="text" name="patronymic" placeholder="Отчество" value="{{ $user->patronymic }}" autocomplete="off"/>
    </div>
    <div class="row">
        <span>E-mail</span>
        <input type="text" name="email" placeholder="E-mail" value="{{ $user->email }}" autocomplete="off"/>
    </div>
    <div class="row">
        <span>Роль в системе</span>
        <select name="role">
        @foreach($roleTitles as $k => $role)
            <option @selected($k == $user->role) value="{{ $k }}">{{ $role }}</option>
        @endforeach
        </select>
    </div>
    <input type="submit" value="Сохранить"/>
    <div class="result center"></div>
</form>
