<h2>{{ $typeTitle }}</h2>
<a class="close"></a>
<form class="close-after" action="{{ route('dictionary.store') }}">
    @csrf
    <div class="row">
        <span>Новый элемент справочника</span>
        <input type="text" name="title" placeholder="Введите название" value="" autocomplete="off"/>
    </div>
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="submit" value="Добавить"/>
</form>
