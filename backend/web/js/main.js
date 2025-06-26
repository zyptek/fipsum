$(window).on('load', function() {
    $('#preloader').fadeOut('slow'); // Esconde el preloader con una animación suave
	
	//Carro compras Squote
    const items = [];

    $('.remove-item').on('click', function() {
        const row = $(this).closest('tr');
        row.remove();
    });

    $('form').on('submit', function(event) {
        event.preventDefault();

        $('#cart tbody tr').each(function() {
            const id = $(this).data('id');
            const mc = $(this).find('.mc').val();
            items.push({ id, mc });
        });

        $('#squote-items').val(JSON.stringify(items));
        this.submit();
    });

});