<div class="content-top">
    @isset($link)
        <a href="#" class="history-back">Вернуться назад</a>
    @endisset
    <div class="user-block">
        <div class="user-to-update">
            @include('components.user-block')
        </div>
        <div class="hidden-menu">
            <div class="link">
                <a class="modal-link change-photo" data-url="{{ route('editPersonalPhoto') }}">Поменять фото профиля</a>
            </div>
            <div class="link">
                <a class="modal-link edit-data" data-url="{{ route('editPersonalData') }}">Редактировать данные</a>
            </div>
            <div class="link">
                <a class="modal-link change-password" data-url="{{ route('editPersonalPassword') }}">Сменить пароль</a>
            </div>
            <div class="divider"></div>
            <div class="link">
                <a class="logout" href="{{ route('logout') }}">Выйти</a>
            </div>
        </div>
    </div>
</div>
