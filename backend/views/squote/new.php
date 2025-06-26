<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */

$this->title = "Nuevo Presupuesto";#.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pquote-new">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
	        [
		        'attribute' => 'id',
		        'label' => 'Presupuesto',
	        ],
            'cm',
            'cmp',
            'subtotal',
            [
            	'attribute' => 'gg',
            	'label' => 'GG 10% + U 10%',
            ],
            'neto',
            'iva',
            'total',
            'created_at',
#            'accepted',
#            'author_accepted',
#            'date_accepted',
#            'approved_f',
#            'approved_c',
            [
            	'attribute' => 'idreq',
            	'label' => 'Requerimiento',
            ],
            [
            	'attribute' => 'idpquote',
            	'label' => 'Cotización',
            ]
        ],
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
	<pre><?php #print_r($idpquote)?></pre>
    <p>
        <?php #= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* = Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]) /**/?>
    </p>

    <?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'idreq',
			'description:ntext',
			'activities:ntext',
            [
            	'attribute' => 'idprovider',
            	'value' => function($model){
	            	$result = $model->provider ? $model->provider->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
			[
	            'attribute' => 'cost',
	            'label' => 'Neto',
	            'value' => function($model){
		            return "$" . number_format($model->cost,"0",",",".");
		         },
            ],
            [
	            'attribute' => 'cost',
	            'label' => 'IVA',
	            'value' => function($model){
		            return "$" . number_format(($model->cost * 0.19),"0",",",".");
		         },
            ],
			[
	            'attribute' => 'cost',
	            'label' => 'Total',
	            'value' => function($model){
		            return "$" . number_format(($model->cost * 1.19),"0",",",".");
		         },
            ],
            'valunt',
			[
				'attribute' => 'payopt:ntext',
	            'value' => function($model){
	            	return "Transferencia Electronica - Abono 50%";
            	}
            ],
			[
				'attribute' => 'payopt:ntext',
	            'label' => 'Términos y Condiciones',
	            'value' => function($model){
	            	return $model->payopt != "" ? $model->payopt : "Sin Información";
            	}
            ],
#            'selected',
#            'activities:ntext',
            
#            'payopt:ntext',
			[
				'attribute' => 'exedr',
	            'value' => function($model){
	            	return $model->exedr != "" ? $model->exedr : "Sin Información";
            	}
            ],
			[
				'attribute' => 'tac:ntext',
	            'value' => function($model){
	            	return $model->tac != "" ? $model->tac : "Sin Información";
            	}
            ],
        ],
    ]) /**/?>

</div>
<style>
table.ppto input{
	height:30px;
	vertical-align: middle;
}
table.ppto button{
	padding:5px;
	border-radius:20px;
}	
</style>
<?php $form = ActiveForm::begin(['action' => Url::to(['squote/index'])]); ?>
<div class="dynamic-rows-form" style="line-height: 8px;">
    <table class="table table-bordered ppto" id="dynamic-table">
        <thead>
            <tr>
                <th>Ítem</th>
                <th>Detalle</th>
                <th>Unidad</th>
                <th>P. Unitario</th>
                <th>Cant.</th>
                <th>Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control" name="item[]" /></td>
                <td><input type="text" class="form-control" name="detalle[]" /></td>
                <td><input type="text" class="form-control" name="unidad[]" /></td>
                <td><input type="number" class="form-control precio numberonly" name="precio_unitario[]" /></td>
                <td><input type="number" class="form-control cantidad numberonly" name="cantidad[]" /></td>
                <td><input type="text" class="form-control total" name="total[]" readonly /></td>
                <td>
                    <button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>COSTO DIRECTO:</strong></td>
                <td><input type="input" class="form-control" name="subtotal" id="costo-directo" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>GG 10% + U 10%:</strong></td>
                <td><input type="input" class="form-control" name="gg" id="gg-u" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>NETO:</strong></td>
                <td><input type="input" class="form-control" name="neto" id="neto" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>IVA:</strong></td>
                <td><input type="input" class="form-control" name="iva" id="iva" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>TOTAL:</strong></td>
                <td><input type="input" class="form-control" name="grand-total" id="grand-total" readonly /></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="idreq" value="<?= $idreq ?>">
    <input type="hidden" name="idpquote" value="<?= $idpquote ?>">
    <?= Html::submitButton('Generar Presupuesto', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
    function calculateRowTotal(row) {
        const precio = parseInt(row.find('.precio').val()) || 0;
        const cantidad = parseInt(row.find('.cantidad').val()) || 0;
        const total = parseInt(precio * cantidad);
        row.find('.total').val(total.toFixed(0));
        calculateCostoDirecto();
        calculateGG();
        calculateNeto();
        calculateIva();
        calculateTotal();
    }

    function calculateCostoDirecto() {
        let costoDirecto = 0;
        $('#dynamic-table .total').each(function () {
            costoDirecto += parseInt($(this).val()) || 0;
        });
        $('#costo-directo').val(costoDirecto.toFixed(0));
    }
	
	function calculateGG() {
        let result = parseInt($('#dynamic-table #costo-directo').val()) || 0;
        result *= 0.2;
        $('#gg-u').val(result.toFixed(0));
    }
    
    function calculateNeto() {
	    let gG = parseInt($('#dynamic-table #gg-u').val()) || 0;
        let costoDirecto = parseInt($('#dynamic-table #costo-directo').val()) || 0;
        result = parseInt(gG + costoDirecto);
        $('#neto').val(result.toFixed(0));
    }
    
    function calculateIva() {
        let result = parseInt($('#dynamic-table #neto').val()) || 0;
        result *= 0.19;
        $('#iva').val(result.toFixed(0));
    }
    
    function calculateTotal() {
        let neto = parseInt($('#dynamic-table #neto').val()) || 0;
        let iva = parseInt($('#dynamic-table #iva').val()) || 0;
        result = parseInt(neto + iva);
        $('#grand-total').val(result.toFixed(0));
    }
    
    $('#dynamic-table').on('click', '.add-row', function () {
        const newRow = `<tr>
            <td><input type="text" class="form-control" name="item[]" /></td>
            <td><input type="text" class="form-control" name="detalle[]" /></td>
            <td><input type="text" class="form-control" name="unidad[]" /></td>
            <td><input type="number" class="form-control precio" name="precio_unitario[]" /></td>
            <td><input type="number" class="form-control cantidad" name="cantidad[]" /></td>
            <td><input type="number" class="form-control total" name="total[]" readonly /></td>
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
        const lastRow = $('#dynamic-table tbody tr:last-child');
        if (!lastRow.find('.add-row').length) {
            lastRow.find('td:last-child').append('<button type="button" class="btn btn-success add-row">+</button>');
        }
        calculateCostoDirecto();
        calculateGG();
        calculateNeto();
        calculateIva();
        calculateTotal();
    });

    $('#dynamic-table').on('input', '.precio, .cantidad', function () {
        const row = $(this).closest('tr');
        calculateRowTotal(row);
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
	    $('button[type="submit"]').on('click', function(event) {
	        if ($('#grand-total').val() < 1) {
			    event.preventDefault();
	            alert('Debe obtener un total antes de continuar.');
	        }
	    });

    });
    $('#dynamic-table').on('paste', 'input[name="item[]"]', function (e) {
	    const row = $(this).closest('tr'); // Fila donde se pega el contenido
	    const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
	    const pastedData = clipboardData.getData('Text'); // Datos del portapapeles
	
	    // Dividir los datos pegados en columnas (asume tabulación o coma como separador)
	    const columns = pastedData.split(/\t|,/);
	
	    // Actualizar los campos de la fila con los datos pegados
	    count = 0;
	    row.find('input').each(function (index) {
		    if (columns[index]) {
	            let value = columns[index].trim();
	            // A partir del segundo campo (índice >= 1), eliminamos los puntos
	            if (index >= 1) {
	                value = value.replace(/\./g, ''); // Eliminar puntos como separadores de miles
	            }
	            $(this).val(value); // Asignar el valor procesado al campo
	        }
		});
		calculateRowTotal(row);

	    // Prevenir el comportamiento predeterminado de pegar en el input original
	    e.preventDefault();
	});
JS
);
?>