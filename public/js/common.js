$(document).ready(function () {

    $('.phone').mask("+7 (999) 999-99-99");
    $('.date').mask('9999-99-99');
    $('.time').mask("99:99");

    $(document).on('click', '.eye', changeInputType);

    $('form').each(function () {
        if (!$(this).hasClass('no-ajax'))
            $(this).on('submit', submitForm);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.file-input').on('change', fileInput);

    $('.submit-button').on('click', function () {
        $(this).addClass('loading').attr('disabled', 'disabled');
        $('#document-form').submit();
    });

    $('.with-reset').find('input').on('input', toggleResetVisibility);
    $('.reset-row-inputs').on('click', function () {
        $(this).removeClass('visible');
        $(this).closest('.row').find('input, select').val('');
    });

    $('.save-document').on('click', function () {
        $(this).addClass('loading').attr('disabled', 'disabled');
        let form = $('#document-form');
        form.find('input[name=is_draft]').val('1');
        form.submit();
    });

    $('.cancel').on('click', function () {
        history.back();
    });

    applyDatepicker();

});

function submitForm() {
    let form = $(this);
    let button = form.find('input[type=submit]');
    let message = [];
    let formData = new FormData(this);
    button.addClass('loading').attr('disabled', 'disabled');
    form.find('.error').removeClass('error');
    $.ajax({
        url: form.attr('action'),
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (data) {
            $('.loading').removeClass('loading').removeAttr('disabled');
            form.find('input[name=is_draft]').val('0');
            showPopUp(data.class ?? 'success', data.message);
            if (form.hasClass('close-after')) {
                closeWindow();
            }
            if (data.url) {
                window.location.href = data.url;
            }
            if (data.reset) {
                form.trigger('reset');
                $('input[type=file]').trigger('change');
            }
            if (data.rowsToDelete) {
                button.remove();
                deleteRows(data.rowsToDelete);
            }
            if (data.newRow) {
                addRow(data.newRow);
            }
            if (data.updateRow) {
                updateRow(data.updateRow, data.row_id);
            }
            if (data.changeStateBtn) {
                $('tr[data-row=' + data.row + ']').find('.set-state').text(data.changeStateBtn);
            }
            if (data.dictionaryItem) {
                newDictionaryItem(data.dictionaryItem);
            }
        },
        error: function (data) {
            $('.loading').removeClass('loading').removeAttr('disabled');
            form.find('input[name=is_draft]').val('0');
            let errors = JSON.parse(data.responseText);
            $.each(errors.errors, function (k, v) {
                if (!inArray(v[0], message)) {
                    message.push(v[0]);
                }
                showError(k, form);
            });
            showPopUp('error', message.join('<br />'));
        }
    });

    return false;
}

function newDictionaryItem(item) {
    let deleteBtn = $('<a />', {
        'class': 'modal-link delete right',
        'data-url': '/modal/delete-dictionary-item/' + item.id
    });

    let div = $('<div />', {
        'class': 'item',
        'data-row': item.id,
        'html': item.title
    });

    div.append(deleteBtn);

    $('.items[data-type="' + item.type + '"]').find('input').before(div);
}

function showPopUp(state, text) {
    let popUp = $('<div />', {
        'class': 'pop-up ' + state,
        'html': text
    });

    $('.pop-ups').prepend(popUp);
    setTimeout(function () {
        popUp.fadeOut(200, function () {
            $(this).remove();
        });
    }, 2000);
}

function getChecked(name) {
    return $('input[name="' + name + '[]"]').map(function () {
        if ($(this).is(':checked')) return $(this).val();
    }).get();
}

function toggleResetVisibility() {
    let cont = $(this).closest('.row');
    let inputs = cont.find('select, input[type=text]');
    let show = false;
    inputs.each(function () {
        if ($(this).val() !== '') {
            show = true;
        }
    });

    if (show) {
        cont.find('.reset-row-inputs').addClass('visible');
    } else {
        cont.find('.reset-row-inputs').removeClass('visible');
    }
}

function fileInput() {
    let $this = $(this);
    let $span = $this.parent().find('i');
    if ($this.prop('multiple')) {
        $span.html($this.val() !== '' ? 'Выбранных файлов: ' + $this.get(0).files.length : $span.data('text'));
    } else {
        $span.html($this.val() !== '' ? $this.get(0).files[0].name : 'Выберите файл');
    }
}

function updateRow(row, rowID) {
    $('.elements').find('[data-row=' + rowID + ']').after(row).remove();
    $('.actions-menu').off().on('click', toggleActionsMenu);
}

function addRow(newRow) {
    $('.elements').find('tbody').prepend(newRow);
    $('.actions-menu').off().on('click', toggleActionsMenu);
}

function deleteRows(rows) {
    for (let row of rows) {
        $('.elements').find('[data-row=' + row + ']').remove();
    }
}

function showError(field, form) {
    field = getField(field, form);
    if (field.length !== 1) {
        return;
    }
    if (field.prop('type') === 'file') {
        field.parent().addClass('error');
    } else {
        field.addClass('error');
    }
}

function getField(field, form) {
    field = field.split('.');
    field = field.length > 1 ? field[0] + "[]" : field[0];
    return form.find("[name='" + field + "']")
}

function inArray(a, array) {
    for (let i of array) {
        if (a === i)
            return true;
    }
    return false;
}

function changeInputType() {
    $(this).toggleClass('opened');
    $(this).parent().find('input').attr('type', function () {
        return $(this).attr('type') === 'text' ? 'password' : 'text';
    });
}

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
