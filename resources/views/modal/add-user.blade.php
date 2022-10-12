<h2>Редактировать данные</h2>
<a class="close"></a>
<form action="{{ route('adm.store') }}" method="post">
    @csrf
    <div class="row">
        <span>Фамилия</span>
        <input type="text" name="surname" placeholder="Фамилия" value="" autocomplete="off" />
    </div>
    <div class="row">
        <span>Имя</span>
        <input type="text" name="name" placeholder="Имя" value="" autocomplete="off"/>
    </div>
    <div class="row">
        <span>Отчество</span>
        <input type="text" name="patronymic" placeholder="Отчество" value="" autocomplete="off"/>
    </div>
    <div class="row">
        <span>E-mail</span>
        <input type="text" name="email" placeholder="E-mail" value="" autocomplete="off"/>
    </div>
    <div class="row">
        <span>Роль в системе</span>
        <select name="role">
            <option value="">Выберите</option>
            @foreach($roleTitles as $k => $role)
            <option value="{{ $k }}">{{ $role }}</option>
            @endforeach
        </select>
    </div>
    <input type="submit" value="Сохранить"/>
    <div class="result center"></div>
</form>
