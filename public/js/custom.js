
(function ($) {

    //$('form#search').attr('action', 'perfomance/consultores');

    $('.select-picker').select2({
        'placeholder': 'Seleccione uma opção',
        'allowClear': true,
        'width': '100%'
    });

    $('input[type="radio"]').on('click', function () {
        switch ($(this).val()) {
            case 'consultores':
                $('form#search').attr('action', $(this).attr('data-url'));
                $('div#consultor-group').removeClass('d-none');
                $('div#cliente-group').addClass('d-none');
                console.log($('form#search').attr('action'));
                break;
            case 'clientes':
                $('form#search').attr('action', $(this).attr('data-url'));
                $('div#cliente-group').removeClass('d-none');
                $('div#consultor-group').addClass('d-none');
                console.log($('form#search').attr('action'));
                break;
        }
    })

    if ($('#btnConsultores').is('checked')) {
        $('form#search').attr('action', $('#btnConsultores').attr('data-url'));
        $('div#consultor-group').removeClass('d-none');
        $('div#cliente-group').addClass('d-none');
    } else if ($('#btnClientes').is(':checked')) {
        $('form#search').attr('action', $('#btnClientes').attr('data-url'));
        $('div#cliente-group').removeClass('d-none');
        $('div#consultor-group').addClass('d-none');
    }

})(jQuery);

