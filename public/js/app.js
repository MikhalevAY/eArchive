$(document).ready(function () {

    $(document).on('click', '.eye', changeInputType);



    $('.color').on('click', chooseColor);

    $('.colorChooser input').on('change', setColor);
    $('.colorChooser').on('click', function () {
        $(this).find('input')[0].click();
    });

    $('.per-page select').on('change', setPerPage);

    $('.actions-menu').on('click', toggleActionsMenu);

    $('.checkbox-toggle-all').on('change', toggleCheckboxes);

    $('.delete-file').on('click', toggleFileDelete);

    // $(document).on('mouseup', function (e) {
    //     let container = $('.actions-menu');
    //     if (!container.is(e.target) && container.has(e.target).length === 0) {
    //         container.find('.submenu').removeClass('opened');
    //     }
    // });

    applyDatepicker();

});

function applyDatepicker() {
    $('input.date').datepicker({
        showOn: "both",
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
    });
}

function toggleFileDelete() {
    $(this).closest('.file-block').find('.file-label').toggleClass('hidden');
}

function toggleCheckboxes() {
    let container = $(this).closest('table');
    let checkboxes = container.find('tbody').find('input[type=checkbox]');
    checkboxes.prop('checked', $(this).is(':checked'));
}

function toggleActionsMenu() {
    let subMenu = $(this).children('.submenu');
    $('.actions-menu .submenu').not(subMenu).removeClass('opened');
    subMenu.toggleClass('opened');
}

function setPerPage() {
    $(this).closest('form').submit();
}

function setColor() {
    $('.color').removeClass('active').removeAttr('style');
    $(this).parent().find('b').text($(this).val());
    $('input[name=color]').val($(this).val());
}

function chooseColor() {
    $(this).addClass('active').css('border-color', $(this).data('border'))
        .siblings().removeClass('active').removeAttr('style');
    $('input[name=color]').val($(this).data('border'));
}

function changeInputType() {
    $(this).parent().find('input').attr('type', function () {
        return $(this).attr('type') === 'text' ? 'password' : 'text';
    });
}
