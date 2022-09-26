<head>
    <link rel="stylesheet" href="./public/css/mail.css" type="text/css">
</head>
<div class="website">{{ config('app.name') }}</div>
<div class="container">
    <p>Здравствуйте, {{ $surname . ' ' . $name }}</p>

    <p>Для Вас была создана учетная запись в системе Электронного Архива.</p>
    <p><b>Логин:</b> {{ $email }}</p>
    <p><b>Пароль:</b> {{ $password }}</p>
    <br/>
    <p>Для перехода к Электронному архиву используйте следующую ссылку:</p>
    <p>{{ config('app.url') }}</p>
    <br/>
    <p>Если вы случайно получили данное сообщение или не имеете доступа к системе Электронного Архива
        просив Вас незамедлительно обратиться в службу ИТ поддержки {{ config('mail.from.address') }}</p>
    <br/>
    <p><small>Это сообщение автоматически сгенерировано системой Электронного Архива в соответствии с
        Вашими пользовательскими настройками. Пожалуйста, не отвечайте на это сообщение, система
        не обрабатывает входящие письма.</small></p>
    <br/>
    <p>С Уважением, <br/>Администрация сайта</p>
</div>
