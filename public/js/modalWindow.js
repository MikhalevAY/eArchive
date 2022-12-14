$(document).ready(function () {
    $(document).on('click', '.modal-link', openWindow);
    $('.modal').on('click', function (e) {
        if (!$(e.target).hasClass('close'))
            e.stopPropagation();
    });
});

function openWindow() {
    let $this = $(this);
    let modalWrapper = $('.modal-wrapper').html('');

    let data = null;
    if (typeof $this.data('post') !== 'undefined') {
        data = getAllIds($this.data('name'));
        if (JSON.parse(data[$this.data('name')]).length === 0) {
            return false;
        }
    }

    if (typeof $this.data('data') !== 'undefined') {
        data = $this.data('data');
    }

    $('.hover_').fadeIn(300);
    $('.modal').hide().attr('class', 'modal');
    $('.modal-window').fadeIn(300);
    if ($(document).height() > $(window).height()) {
        $('body').addClass('no-scroll');
    }
    $.ajax({
        'url': $this.data('url'),
        'data': data,
        'type': 'POST',
        'dataType': 'html',
        'success': function (html) {
            modalWrapper.html(html);
            $('.modal').fadeIn(300).addClass($this.data('class'));
            modalWrapper.find('form').each(function () {
                if (!$(this).hasClass('no-ajax'))
                    $(this).on('submit', submitForm);
            });
            setDefaultFunctions();
        },
        'error': function () {
            $('.close').on('click', closeWindow);
        }
    });
}

function getAllIds(name) {
    let elements = getChecked(name);
    return {[name]: JSON.stringify(elements)};
}

function setDefaultFunctions() {
    $('.phone').mask("+7 (999) 999-99-99");
    $('.date').mask('9999-99-99');
    $('.close').on('click', closeWindow);
    $('.eye').on('click', changeInputType);
    $('.file-input').on('change', fileInput);
    $('.toggle-doc-access').on('click', toggleDocAccess);
    applyDatepicker();
}

function closeWindow() {
    $('.modal').hide();
    $('.modal-window').fadeOut(300);
    $('.elements').find('input[type=checkbox]').prop('checked', false);
    $('body').removeClass('no-scroll');
}
