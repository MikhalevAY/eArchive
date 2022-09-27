$(document).ready(function () {

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

});

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
