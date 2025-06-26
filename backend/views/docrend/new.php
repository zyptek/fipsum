<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var backend\models\Docrend $model */

$this->title = "Nuevo DR";
$this->params['breadcrumbs'][] = ['label' => 'Documentos Rendición', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="docrend-view">

    <h1>Documento de Rendición</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'idreq',
            [
            	'attribute' => 'assigned_amount',
            	'value' => function($model){
	            	return number_format($model->assigned_amount, 0, ',', '.');
            	}
            ],
#            'expended_amount',
#            'difference',
#            'total',
#            'responsable',
#            'presented_by',
#            'count_boletas',
#            'count_peajes',
#            'count_facturas',
#            'count_nc',
        ],
    ]) ?>

</div>
<style>
table.ppto input, table.ppto .form-control{
	height:30px;
	vertical-align: middle;
}
table.ppto button{
	padding:5px;
	border-radius:20px;
}	
</style>
<?php $form = ActiveForm::begin(['action' => Url::to(['view', 'id' => $model->id]),
		'options' => ['id' => 'docrendForm']
	]); 
	$select = "";
	foreach($toe as $type){
		$select .= "<option value='$type->id'>$type->name</option>";
	}
	$count = 0;
?>
<div class="dynamic-rows-form" style="line-height: 8px;">
    <table class="table table-bordered ppto" id="dynamic-table">
        <thead>
            <tr>
                <th>Fecha Emisión</th>
                <th>Ítem</th>
                <th>Poveedor</th>
                <th>Tipo Doc.</th>
                <th>Nº Doc</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="date" class="form-control" name="fecha[]" /></td>
                <td><input type="text" class="form-control" name="detalle[]" /></td>
                <td><input type="text" class="form-control" name="proveedor[]" /></td>
                <td><select class="form-control toe" name="toe[]" id="toe<?= $count ?>">
	                <?= $select ?>
					</select></td>
                <td><input type="text" class="form-control numberonly" name="no_doc[]" /></td>
                <td><input type="text" class="form-control valor numberonly" name="valor[]" /></td>
                <td>
	                <button type="button" class="btn btn-danger remove-row"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Facturas:</strong></td>
                <td><input type="input" class="form-control" name="cant-facturas" id="cant-facturas" readonly /></td>
                <td  class="text-right" style="vertical-align: middle;"><strong>Total Facturas:</strong></td>
                <td><input type="input" class="form-control" name="total-facturas" id="total-facturas" readonly /></td>
                <td></td>
            </tr>
            <tr>
	            <td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Boletas:</strong></td>
                <td><input type="input" class="form-control" name="cant-boletas" id="cant-boletas" readonly /></td>
                <td class="text-right" style="vertical-align: middle;"><strong>Total Boletas:</strong></td>
                <td><input type="input" class="form-control" name="total-boletas" id="total-boletas" readonly /></td>
                <td></td>
            </tr>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Peajes:</strong></td>
                <td><input type="input" class="form-control" name="cant-peajes" id="cant-peajes" readonly /></td>
                <td  class="text-right" style="vertical-align: middle;"><strong>Total Peajes:</strong></td>
                <td><input type="input" class="form-control" name="total-peajes" id="total-peajes" readonly /></td>
                <td></td>
            </tr>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>N. Crédito:</strong></td>
                <td><input type="input" class="form-control" name="cant-nc" id="cant-nc" readonly /></td>
                <td class="text-right" style="vertical-align: middle;"><strong>Total N. Crédito:</strong></td>
                <td><input type="input" class="form-control" name="total-nc" id="total-nc" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"class="text-right" style="vertical-align: middle;"><strong>Total General:</strong></td>
                <td><input type="input" class="form-control" name="grand-total" id="grand-total" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"class="text-right" style="vertical-align: middle;"><strong>Resultado/A Pagar:</strong></td>
                <td><input type="input" class="form-control" name="resultado" id="resultado" readonly /></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="idreq" value="<?= $model->idreq ?>">

    <?= Html::button('Consolidar Rendición', ['class' => 'btn btn-success', 'id' => 'send']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
	function calculateItems(){
		var res = {
		    1: { total: 0, count: 0 },
			2: { total: 0, count: 0 },
			3: { total: 0, count: 0 },
			4: { total: 0, count: 0 }
		};
		
		$('#dynamic-table tbody tr').each(function() {

		    var opcion = $(this).find('select[name="toe[]"]').val();
		
		    // Obtenemos el valor numérico del input (en este ejemplo, del input con name="valor[]")
		    var valor = parseFloat($(this).find('input[name="valor[]"]').val()) || 0;
		
		    // Si la opción existe en nuestro objeto, acumulamos el valor y contamos la aparición
		    if(res.hasOwnProperty(opcion)){
		        res[opcion].total += valor;
		        res[opcion].count++;
		    }
		});
		
		$('#total-boletas').val(res[1].total);
		$('#cant-boletas').val(res[1].count);
		$('#total-facturas').val(res[3].total);
		$('#cant-facturas').val(res[3].count);
		$('#total-peajes').val(res[2].total);
		$('#cant-peajes').val(res[2].count);
		$('#total-nc').val(res[4].total);
		$('#cant-nc').val(res[4].count);
		
		calculateTotal();
		calculateResultado();
	}

    
    function calculateTotal() {
        let boletas = parseInt($('#dynamic-table #total-boletas').val()) || 0;
        let facturas = parseInt($('#dynamic-table #total-facturas').val()) || 0;
        let peajes = parseInt($('#dynamic-table #total-peajes').val()) || 0;
        let nc = parseInt($('#dynamic-table #total-nc').val()) || 0;
        result = parseInt((boletas + facturas + peajes) - nc);
        $('#grand-total').val(result.toFixed(0));
    }
    
    function calculateResultado(){
		
		let assigned = $model->assigned_amount;
		let tot = $('#grand-total').val();
		if(assigned > tot){
			var res = assigned - tot;
			$('#resultado').val("-" + res)
			$('#resultado').css('color', 'red');
		}else{
			var res = tot - assigned;
			$('#resultado').val(res)
			$('#resultado').css('color', 'black');
		}
	    
	}
	
    let count = 0;
    $('#dynamic-table').on('click', '.add-row', function () {
        const newRow = `<tr>
            <td><input type="date" class="form-control" name="fecha[]" /></td>
            <td><input type="text" class="form-control" name="detalle[]" /></td>
            <td><input type="text" class="form-control" name="proveedor[]" /></td>
            <td><select class="form-control toe" name="toe[]" id="toe`+ ++count + `">
                $select
				</select></td>
            <td><input type="text" class="form-control numberonly" name="no_doc[]" /></td>
            <td><input type="text" class="form-control valor numberonly" name="valor[]" /></td>
            <td>
                <button type="button" class="btn btn-danger remove-row"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>
            </td>
        </tr>`;
        $('#dynamic-table tbody').append(newRow);
        $(this).remove();
    });

    $('#dynamic-table').on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
        if($('#dynamic-table tbody tr').length === 0) {
	        const newRow = `<tr>
	            <td><input type="date" class="form-control" name="fecha[]" /></td>
	            <td><input type="text" class="form-control" name="detalle[]" /></td>
	            <td><input type="text" class="form-control" name="proveedor[]" /></td>
	            <td><select class="form-control toe" name="toe[]" id="toe`+ ++count + `">
	                $select
					</select></td>
	            <td><input type="text" class="form-control numberonly" name="no_doc[]" /></td>
	            <td><input type="text" class="form-control valor numberonly" name="valor[]" /></td>
	            <td>
	                <button type="button" class="btn btn-danger remove-row"><i class="fas fa-minus"></i></button>
	                <button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>
	            </td>
	        </tr>`;
	        $('#dynamic-table tbody').append(newRow);
	    }else{
	        const lastRow = $('#dynamic-table tbody tr:last-child');
	        if (!lastRow.find('.add-row').length) {
	            lastRow.find('td:last-child').append('<button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>');
	        }
		}
        calculateItems();
    });

    $('#dynamic-table').on('input', '.valor', function () {
        calculateItems();
    });
        $('#dynamic-table').on('change', '.toe', function () {
        calculateItems();
    });
    $(document).ready(function() {
        $('.numberonly').on('keypress', function(event) {
            // Obtener el código de la tecla presionada
            var charCode = event.which;

            // Permitir números (0-9), teclas de control como Backspace (8) y Tab (9)
            if (charCode >= 48 && charCode <= 57 || charCode === 8 || charCode === 9) {
                return true;
            }

            // Prevenir la entrada de otros caracteres
            return false;
        });
        
	        // Detecta clic en el botón de envío deshabilitado
	    $('button#send').on('click', function(event) {
		    let valido = false;
		    $("input[name='fecha[]']").each(function() {
	            if ($(this).val().trim() === "") {
	                valido = false;
	                $(this).css("border", "2px solid red"); // Opcional: resaltar los inputs vacíos
	            } else {
	                $(this).css("border", ""); // Restaurar el borde si está completo
	                valido = true;
	            }
	        });
	        if ($('#grand-total').val() < 1 || !valido) {
			    event.preventDefault();
	            alert('Debe obtener un total antes de continuar.');
	        }else{
	        	$("#docrendForm").submit();
			}
	    });
		$("input[name='fecha[]']").on('change', function(){
			$(this).css("border", "");
			
		});
    });
JS
);
?>