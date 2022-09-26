<head>
    <link rel="stylesheet" href="./public/css/mail.css" type="text/css">
</head>
<div class="website">{{ config('app.name') }}</div>
<div class="container">
    <h2>Сброс пароля на сайте</h2>
    <p>Здравствуйте, администрация сайта сбросила вам пароль.</p>
    <p>Данные для авторизации:</p>
    <p><b>Логин:</b> {{ $email }}</p>
    <p><b>Пароль:</b> {{ $password }}</p>
    <br />
    <p>{{ config('app.url') }}</p>
    <br /><p>С Уважением, <br />Администрация сайта</p>
</div>
