$(document).ready(function () {
    $(document).on('click', '.modal-link', openWindow);
    //$(document).on('click', '.modal-window', closeWindow);
    $('.modal').on('click', function (e) {
        if (!$(e.target).hasClass('close'))
            e.stopPropagation();
    });
});

function openWindow() {
    let $this = $(this);
    let modalWrapper = $('.modal-wrapper').html('');
    $('.hover_').fadeIn(300);
    $('.modal').hide().attr('class', 'modal');
    $('.modal-window').fadeIn(300);
    if ($(document).height() > $(window).height()) {
        $('body').addClass('no-scroll');
    }
    $.ajax({
        url: $this.data('url'),
        type: 'POST',
        dataType: 'html',
        success: function (html) {
            modalWrapper.html(html);
            $('.modal').fadeIn(300).addClass($this.data('class'));
            modalWrapper.find('form').each(function () {
                if (!$(this).hasClass('no-ajax'))
                    $(this).on('submit', submitForm);
            });
            if ($this.data('checkboxes')) {
                setCheckboxInput($this.data('checkboxes'));
            }
            setDefaultFunctions();
        },
        error: function () {
            $('.close').on('click', closeWindow);
        }
    });
}

function setCheckboxInput(name) {
    let val = $('input[name="' + name + '[]"]').map(function () {
        if ($(this).is(':checked')) return $(this).val();
    }).get();
    $('.modal').find('input[name=checkboxes]').val(val.join(','));
}

function setDefaultFunctions() {
    $('.phone').mask("+7 (999) 999-99-99");
    $('.close').on('click', closeWindow);
    $('.eye').on('click', changeInputType);
    $('.file-input').on('change', fileInput);
    $('.modal-link').unbind().bind('click', openWindow);
    applyDatepicker();
}

function closeWindow() {
    $('.modal').hide();
    $('.modal-window').fadeOut(300);
    $('body').removeClass('no-scroll');
}
