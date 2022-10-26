<h2>Сменить фото</h2>
<a class="close"></a>
<form class="close-after" action="{{ route('updatePersonalPhoto') }}" method="post">
    @csrf
    <div class="row">
        <span>Фото</span>
        <label class="file-label" for="photo">
            <div><i class="file-name">Выберите файл</i></div>
            <input class="file-input" id="photo" type="file" name="photo">
        </label>
    </div>
    <input type="submit" value="Сохранить"/>
    <div class="result center"></div>
</form>
