$(document).ready(function() {
	$('#submit-btn').click(function() {
        var form = $('#image-upload-form')[0];
        var formData = new FormData(form);
	
	
	
/*    $('#image-upload-form').on('beforeSubmit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
/**/
        
        // Asegúrate de que no haya duplicados de '_csrf-backend'
        formData.delete('_csrf-backend');  // Eliminar cualquier valor duplicado de CSRF
        
        // Agregar CSRF token al FormData
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        formData.append('_csrf-backend', csrfToken);  

        // Mostrar loader y deshabilitar el botón
        $('#loader').show();
        $('#submit-btn').prop('disabled', true);

        // Verificar datos antes de enviarlos
//        console.log("Datos del formulario enviados:", formData);
        
        $.ajax({
            url: $('#image-upload-form').attr('action'), //form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
//                console.log("Respuesta del servidor:", response);
                $('#loader').hide();
                $('#submit-btn').prop('disabled', false);
                if (response.success) {
                    alert('Imagen subida exitosamente');
//                    location.reload();
					$("#image-upload-form").trigger("reset");
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                $('#submit-btn').prop('disabled', false);
                console.log("Error AJAX:", status, error);  // Ver detalles del error
                alert('Ocurrió un error al subir la imagen.');
            }
        });
        return false;  // Prevenir el envío normal del formulario
    });
    

/*
	$('.delete-button').on('click', function(e) {
	    e.preventDefault();
		console.log("hola");
	    if (!confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
	        return;
	    }
	
	    var button = $(this);
	    var url = button.data('url'); // Obtiene la URL de eliminación
	    var container = '#image-gallery-container'; // Contenedor de la galería
	
	    $.post(url, function(response) {
	        if (response.success) {
	            // Recargar la galería
	            $.ajax({
	                url: window.location.href, // Usa la misma URL de la página para recargar
	                type: 'GET',
	                success: function(html) {
	                    var newGallery = $(html).find(container).html(); // Extrae el contenido del contenedor
	                    $(container).html(newGallery); // Reemplaza el contenido actual
	                },
	                error: function() {
	                    alert('Hubo un error al recargar la galería.');
	                }
	            });
	        } else {
	            alert(response.message || 'Error al eliminar la imagen.');
	        }
	    }).fail(function() {
	        alert('No se pudo completar la solicitud.');
	    });
	});
*/
    
    
/*
    $(document).on('click', '.delete-button', function (e) {
        e.preventDefault();
        
        console.log("hola2");
        
        let deleteUrl = $(this).attr('href');
        let imageItem = $(this).closest('.image-item');
        
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                success: function (response) {
                    if (response.success) {
                        imageItem.fadeOut('slow', function () { 
                            $(this).remove(); 
                        });
                    } else {
                        alert('Error al eliminar la imagen.');
                    }
                },
                error: function () {
                    alert('Error en la solicitud AJAX.');
                }
            });
        }
    });
*/
    
    
$('.delete-button').on('click', function(e) {
	e.preventDefault();
	console.log("hola");
    let button = $(this);
    let imageId = button.data('id');
    
    if (confirm('¿Está seguro de eliminar esta imagen?')) {
        $.ajax({
            url: '/image/delete?id=' + imageId,
            type: 'POST',
            data: { id: imageId, _csrf: yii.getCsrfToken() },
            success: function(response) {
                if (response.success) {
                    $('#image-' + imageId).fadeOut(300, function() { $(this).remove(); });
                    console.log("eliminada");
                } else {
                    alert('Error al eliminar la imagen.');
                }
            },
            error: function() {
                alert('No se pudo conectar con el servidor.');
            }
        });
    }
});


});
