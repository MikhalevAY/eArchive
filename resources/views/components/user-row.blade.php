<tr data-row="{{ $user->id }}">
    <td>
        <label class="checkbox">
            <input type="checkbox" value="{{ $user->id }}" name="users[]">
            <div class="checkmark"></div>
        </label>
    </td>
    <td class="light">{{ $user->id }}</td>
    <td>{{ $user->surname }}</td>
    <td>{{ $user->name . ' ' . $user->patronymic }}</td>
    <td>{{ $role }}</td>
    <td class="text-center">{{ $user->created_at->format('d.m.Y в H:i') }}</td>
    <td>
        <div class="actions-menu">
            <div class="submenu">
                <a class="modal-link edit" data-url="{{ route('editUser', ['user' => $user->id]) }}">Редактировать</a>
                <a class="modal-link reset-password" data-url="{{ route('resetPassword', ['user' => $user->id]) }}">Сбросить
                    пароль</a>
                <a class="modal-link set-state"
                   data-url="{{ route('changeUserState', ['user' => $user->id]) }}">{{ $user->is_active ? 'Деактивировать' : 'Активировать' }}</a>
                <a class="modal-link delete" data-url="{{ route('deleteUser', ['user' => $user->id]) }}">Удалить</a>
            </div>
        </div>
    </td>
</tr>
