<h2>Редактировать данные</h2>
<a class="close"></a>
<form action="{{ route('updatePersonalData') }}" method="post">
    @csrf
    <div class="row">
        <span>Фамилия</span>
        <input type="text" name="surname" placeholder="Фамилия" value="{{ auth()->user()->surname }}" autocomplete="off" />
    </div>
    <div class="row">
        <span>Имя</span>
        <input type="text" name="name" placeholder="Имя" value="{{ auth()->user()->name }}" autocomplete="off"/>
    </div>
    <div class="row">
        <span>Отчество</span>
        <input type="text" name="patronymic" placeholder="Отчество" value="{{ auth()->user()->patronymic }}" autocomplete="off"/>
    </div>
    <div class="row">
        <span>E-mail</span>
        <input type="text" name="email" placeholder="E-mail" value="{{ auth()->user()->email }}" autocomplete="off"/>
    </div>
    <input type="submit" value="Сохранить"/>
    <div class="result center"></div>
</form>
