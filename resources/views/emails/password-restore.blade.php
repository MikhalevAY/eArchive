<head>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .website {
            background: #194d93;
            padding: 15px 30px;
            text-align: center;
            max-width: 500px;
            color: #FFF;
            font-size: 20px;
            line-height: 20px;
            font-weight: 300;
            margin:0 auto;
        }
        .container {
            background: #FAFAFA;
            max-width: 500px;
            margin: 0 auto;
            padding: 15px 30px;
        }
        h2 {
            font-size: 18px;
            text-align: center;
            color: #444;
        }
        p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

    </style>
</head>
<div class="website">{{ config('app.name') }}</div>
<div class="container">
    <h2>Сброс пароля на сайте</h2>
    <p>Здравствуйте, вами был подан запрос на сброс пароля для учетной записи в системе Электронного Архива.</p>
    <p>Для сброса пароля используйте следующую ссылку:</p>
    <p>{{ route('newPassword', ['md5Email' => $md5Email]) }}</p>
    <br/>
    <p><b>Игнорируйте это сообщение, если вы НЕ запрашивали изменение/сброс пароля.</b></p>
    <br/>
    <p><small>Это сообщение автоматически сгенерировано системой Электронного Архива в соответствии с
            Вашими пользовательскими настройками. Пожалуйста, не отвечайте на это сообщение, система
            не обрабатывает входящие письма.</small></p>
    <br/>
    <p>С Уважением, <br/>Администрация сайта</p>
</div>
