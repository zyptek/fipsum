$(document).ready(function() {
    $('#select-company').change(function() {
        var companyId = $(this).val();
//        var $branchSelect = $('#select-branch');
//        var $solicitorSelect = $('#select-solicitor');
        var $branchSelect = $('#req-idbranch');
        var $solicitorSelect = $('#req-idsolicitor');
        
        // limpiar campos
        $branchSelect.html('<option value="">Seleccione...</option>');
		$solicitorSelect.html('<option value="">Seleccione...</option>');

        if (companyId) {
            $.ajax({
                url: branchesUrl, // Usamos la variable generada en PHP
                data: { company_id: companyId },
                dataType: 'json',
                success: function(data) {
                    if (Array.isArray(data)) {
                        $.each(data, function(key, value) {
                            $branchSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        alert('Formato de datos inválido');
                    }
                },
                error: function() {
                    alert('Error al cargar sucursales');
                }
            });
            $.ajax({
                url: solicitorUrl, // Usamos la variable generada en PHP
                data: { company_id: companyId },
                dataType: 'json',
                success: function(data) {
                    if (Array.isArray(data)) {
                        $.each(data, function(key, value) {
                            $solicitorSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        alert('Formato de datos inválido');
                    }
                },
                error: function() {
                    alert('Error al cargar solicitantes');
                }
            });
        }
    });
});
