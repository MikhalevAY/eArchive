$(document).ready(function () {

    $('.phone').mask("+7 (999) 999-99-99");

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

    $('.save-document').on('click', function () {
        $(this).addClass('loading').attr('disabled', 'disabled');
        let form = $('#document-form');
        form.find('input[name=is_draft]').val('1');
        form.submit();
    });

});

function submitForm() {
    let form = $(this);
    let button = form.find('input[type=submit]');
    let result = form.find('.result');
    let message = [];
    let formData = new FormData(this);
    button.addClass('loading').attr('disabled', 'disabled');
    result.html('').removeClass('error success');
    form.find('.error').removeClass('error');
    $.ajax({
        url: form.attr('action'),
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (data) {
            $('.loading').removeClass('loading').removeAttr('disabled');
            if (data.url) {
                window.location.href = data.url;
            }
            if (data.reset) {
                form.trigger('reset');
                $('input[type=file]').trigger('change');
            }
            if (data.closeWindow) {
                setTimeout(closeWindow, 2000);
            }
            if (data.rowsToDelete) {
                deleteRows(data.rowsToDelete);
            }
            result.addClass('success').html(data.message);
        },
        error: function (data) {
            $('.loading').removeClass('loading').removeAttr('disabled');
            let errors = JSON.parse(data.responseText);
            $.each(errors.errors, function (k, v) {
                if (!inArray(v[0], message)) {
                    message.push(v[0]);
                }
                showError(k, form);
            });
            result.addClass('error').html(message.join('<br />'));
        }
    });

    return false;
}

function fileInput() {
    let $this = $(this);
    let $span = $this.parent().find('i');
    if ($this.prop('multiple')) {
        $span.html($this.val() !== '' ? 'Выбранных файлов: ' + $this.get(0).files.length : 'Выберите файлы');
    } else {
        $span.html($this.val() !== '' ? $this.get(0).files[0].name : 'Выберите файл');
    }
}

function deleteRows(rows) {
    for (let row of rows) {
        $('.elements').find('tr[data-row=' + row + ']').remove();
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
