$(document).ready(function () {

    $('.color').on('click', chooseColor);

    $('.colorChooser input').on('change', setColor);
    $('.colorChooser').on('click', function () {
        $(this).find('input')[0].click();
    });

    $('.per-page select').on('change', setPerPage);

    $('.actions-menu').on('click', toggleActionsMenu);

    $(document).on('mouseup', function (e) {
        let container = $('.actions-menu');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.find('.submenu').removeClass('opened');
        }
    });

    $('.checkbox-toggle-all').on('change', toggleCheckboxes);

    $('.delete-file').on('click', toggleFileDelete);

    $('.delete-attachment').on('click', deleteAttachment);

    $('.history-back').on('click', function () {
        history.back();
        return false;
    });

    $('.action-with-selected').on('click', actionWithSelected);

    $('.toggle-link').on('click', toggleDocumentInfo);

    $('.dictionary h1').on('click', toggleItems);

});

function toggleItems() {
    let cont = $(this).parent();
    cont.toggleClass('closed');
    cont.find('.items').slideToggle(100);
}

function actionWithSelected() {
    let documents = getChecked('documents');
    let $this = $(this);

    $.ajax({
        type: 'GET',
        url: '/documents/action-with-selected',
        data: {'documents': documents, 'type': $this.data('type')},
        dataType: 'json',
        success: function (data) {
            document.location.href = data.url + '?documents=' + documents.join(',');
        },
        statusCode: {
            400: function (data) {
                showPopUp('error', data.responseJSON.message);
            }
        },
    });
}

function toggleDocAccess() {
    let $this = $(this), val;
    if ($this.parent().hasClass('allowed')) {
        $this.parent().attr('class', 'doc forbidden');
        $this.val($this.data('allow'));
        val = 0;
    } else {
        $this.parent().attr('class', 'doc allowed');
        $this.val($this.data('forbid'));
        val = 1;
    }
    $this.parent().find('input[type=hidden]').val(val);
}

function toggleDocumentInfo() {
    $(this).hide().siblings('a').show();
    $(this).parent().children('table').toggleClass('closed');
}

function toggleFileDelete() {
    let cont = $(this).closest('.file-block');
    let file = cont.find('.file-label');
    file.toggleClass('hidden');
    cont.find('input[name=' + file.data('deleted') + ']').val(file.is(':visible') ? 1 : '');
}

function deleteAttachment() {
    let cont = $(this).closest('.attachment');
    cont.find('input[type=checkbox]').prop('checked', true);
    cont.hide();
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
    let url = new URL(document.location.href);
    url.searchParams.set('per_page', $(this).val());
    document.location.href = url.href;
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
