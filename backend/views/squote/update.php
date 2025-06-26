<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */

$this->title = "Editar Presupuesto";#.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$gtkms = $const->gtkms;
$hhdtec = $const->hhdtec;
$hhdls2 = $const->hhdls2;
$hhntec = $const->hhntec;
$hhnls2 = $const->hhnls2;
$bxztec = $const->bxztec;
$bxzls2 = $const->bxzls2;
$ggu = $const->ggu;

?>

<div class="pquote-new">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
	        [
		        'attribute' => 'id',
		        'label' => 'Presupuesto',
	        ],
	        'idreq',
            'cm',
            'cmp',
#            'subtotal',
/*
            [
            	'attribute' => 'gg',
            	'label' => 'GG 10% + U 10%',
            ],
*/
#            'neto',
#            'iva',
#            'total',
            'created_at',
#            'accepted',
#            'author_accepted',
#            'date_accepted',
#            'approved_f',
#            'approved_c',
/*
            [
            	'attribute' => 'idpquote',
            	'label' => 'Cotización',
            ]
*/
        ],
    ]) ?>

    <h2>Costos Informados</h2>


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
<?php $form = ActiveForm::begin(/*[ 'action' => Url::to(['squote/index'])]*/); ?>
<div>
<table class="table table-bordered ppto" id="gastos-internos"><thead>
  <tr>
    <th class="" colspan="6" style="background-color: #6796e5; color:white;">Materiales</th>
  </tr></thead>
<tbody>
  <tr>
    <td class=""><input type="text" class="form-control numberonly" name="mat-tot" id="mat-tot" placeholder="Total" /></td>
    <td class="" colspan="5"><input type="text" class="form-control" name="mat-desc" id="mat-desc" placeholder="Descripción" /></td>
  </tr>
  <tr>
    <td class="" style="background-color: #6796e5; color:white;"></td>
    <td class="" style="background-color: #6796e5; color:white; font-weight: 700">HHD</td>
    <td class="" colspan="1" style="background-color: #6796e5; color:white; font-weight: 700">HHN</td>
    <td class="" colspan="3" style="background-color: #6796e5; color:white; font-weight: 700">Gastos Traslados</td>

  </tr>
  <tr>
    <td class="" style="font-weight: 700">Técnico</td>
    <td class=""><input type="text" class="form-control numberonly" name="hhd-tec" id="hhd-tec" /></td>
    <td class="" colspan="1"><input type="text" class="form-control" name="hhn-tec" id="hhn-tec" /></td>
    <td class="" colspan="2" style="font-weight: 700">Peaje</td>
    <td class=""><input type="text" class="form-control numberonly" name="gt-peaje" id="gt-peaje" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">LS2</td>
    <td class=""><input type="text" class="form-control numberonly" name="hhd-ls2" id="hhd-ls2" /></td>
    <td class="" colspan="1"><input type="text" class="form-control" name="hhn-ls2" id="hhn-ls2" /></td>
    <td class="" colspan="2" style="font-weight: 700">Estacionamiento</td>
    <td class=""><input type="text" class="form-control numberonly" name="gt-estac" id="gt-estac" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Días</td>
    <td class=""><input type="text" class="form-control numberonly" name="hhd-dias" id="hhd-dias" /></td>
    <td class="" colspan="1"><input type="text" class="form-control" name="hhn-dias" id="hhn-dias" /></td>
    <td class="" colspan="2" style="font-weight: 700">Km</td>
    <td class=""><input type="text" class="form-control numberonly" name="gt-km" id="gt-km" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Total</td>
    <td class=""><input type="text" class="form-control numberonly" name="hhd-tot" id="hhd-tot" disabled /></td>
    <td class="" colspan="1"><input type="text" class="form-control" name="hhn-tot" id="hhn-tot" disabled /></td>
    <td class="" colspan="2" style="font-weight: 700">Total</td>
    <td class=""><input type="text" class="form-control numberonly" name="gt-tot" id="gt-tot" disabled /></td>

  </tr>
  <tr>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Bono Por zona</td>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Alojamiento y Colaciones</td>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Resumen</td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Técnico</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="bxz-tec" id="bxz-tec" /></td>
    <td class="" style="font-weight: 700">Alojamiento</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="ayc-aloj" id="ayc-aloj" /></td>
    <td style="font-weight: 700">Total</td>
    <td><input type="text" class="form-control numberonly" name="total" id="res-total" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">LS2</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="bxz-ls2" id="bxz-ls2" /></td>
    <td class="" style="font-weight: 700">Colaciones</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="ayc-col" id="ayc-col" /></td>
	<td style="font-weight: 700">MC %</td>
	<td><input type="text" class="form-control numberonly" name="ayc-aloj" id="ayc-aloj" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Días</td>
    <td class="" colspan="1" ><input type="text" class="form-control numberonly" name="bxz-dias" id="bxz-dias" /></td>
    <td class="" style="font-weight: 700">Días</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="ayc-dias" id="ayc-dias" /></td>
	<td style="font-weight: 700">MC $</td>
	<td><input type="text" class="form-control numberonly" name="ayc-aloj" id="ayc-aloj" /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Total</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="bxz-tot" id="bxz-tot" disabled/></td>
    <td class="" style="font-weight: 700">Total</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" name="ayc-tot" id="ayc-tot" disabled/></td>
    <td style="font-weight: 700">Venta Costo</td>
    <td><input type="text" class="form-control numberonly" name="ayc-aloj" id="ayc-aloj" disabled/></td>
  </tr></tbody></table>
</div>
<h2>Presupuesto</h2>
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
        <?php
	        $details = $model->squoteDetails;
	        foreach(!empty($details) ? $details : ['null'] as $i => $detail): ?>
            <tr>
                <td><input type="text" class="form-control" name="item[]" <?= ($detail == "null") ? "" : "value=" . $detail['item'] ?>  /></td>
                <td><input type="text" class="form-control" name="detalle[]" <?= ($detail == "null") ? "" : "value=" . $detail['descrip'] ?> /></td>
                <td><input type="text" class="form-control" name="unidad[]" <?= ($detail == "null") ? "" : "value=" . $detail['unit'] ?> /></td>
                <td><input type="number" class="form-control precio numberonly" name="precio_unitario[]" <?= ($detail == "null") ? "" : "value=" . $detail['cost'] ?> /></td>
                <td><input type="number" class="form-control cantidad numberonly" name="cantidad[]" <?= ($detail == "null") ? "" : "value=" . $detail['quant'] ?> /></td>
                <td><input type="text" class="form-control total" name="total[]" readonly <?= ($detail == "null") ? "" : "value=" . $detail['total'] ?> /></td>
                <td>
                    <?= (($i+1) == count($details)) ? "<button type='button' class='btn btn-success add-row'><i class='fas fa-plus'></i></button>" : "" ?>
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-minus"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>COSTO DIRECTO: </strong></td>
                <td><input type="input" class="form-control" name="subtotal" id="costo-directo" <?= (empty($details)) ? "" : "value=" . $model->subtotal ?> readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>GG 10% + U 10%:</strong></td>
                <td><input type="input" class="form-control" name="gg" id="gg-u" <?= (empty($details)) ? "" : "value=" . $model->gg ?> readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>NETO:</strong></td>
                <td><input type="input" class="form-control" name="neto" id="neto" <?= (empty($details)) ? "" : "value=" . $model->neto ?> readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>IVA:</strong></td>
                <td><input type="input" class="form-control" name="iva" id="iva" <?= (empty($details)) ? "" : "value=" . $model->iva ?> readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>TOTAL:</strong></td>
                <td><input type="input" class="form-control" name="grand-total" id="grand-total" <?= (empty($details)) ? "" : "value=" . $model->total ?> readonly /></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

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
	
/* Gastos Internos */
	function calculateHhd(){
		let result = 0;
		let resA = $('#gastos-internos #hhd-tec').val()*{$hhdtec};
		let resB = $('#gastos-internos #hhd-ls2').val()*{$hhdls2};
		result = (resA + resB) * $('#gastos-internos #hhd-dias').val();
		$('#gastos-internos #hhd-tot').val(Math.round(result));
	}
	function calculateHhn(){
		let result = 0;
		let resA = $('#gastos-internos #hhn-tec').val()*{$hhntec};
		let resB = $('#gastos-internos #hhn-ls2').val()*{$hhnls2};
		result = (resA + resB) * $('#gastos-internos #hhn-dias').val();
		$('#gastos-internos #hhn-tot').val(Math.round(result));
	}
	function calculateGT(){
		let result = 0;
		let kms = ($('#gastos-internos #gt-km').val() * {$gtkms}) || 0;
		let estac = $('#gastos-internos #gt-estac').val() || 0;
		let peaje = $('#gastos-internos #gt-peaje').val() || 0;
		result = (parseFloat(peaje) + parseFloat(estac) + parseFloat(kms));
		console.log( peaje,"+", estac, kms);
		$('#gastos-internos #gt-tot').val(Math.round(result));
	}
	function calculateBxZ(){
		let result = 0;
		let tec = ($('#gastos-internos #bxz-tec').val() * {$bxztec}) || 0;
		let ls2 = ($('#gastos-internos #bxz-ls2').val() * {$bxzls2}) || 0;
		let dias = $('#gastos-internos #bxz-dias').val() || 0;
		result = ((parseFloat(tec) + parseFloat(ls2)) * parseFloat(dias));
		$('#gastos-internos #bxz-tot').val(Math.round(result));
	}
	function calculateAyC(){
		let result = 0;
		let A = $('#gastos-internos #ayc-aloj').val() || 0;
		let C = $('#gastos-internos #ayc-col').val() || 0;
		let tec = $('#gastos-internos #bxz-tec').val() || 0;
		let ls2 = $('#gastos-internos #bxz-ls2').val() || 0;
		let dias = $('#gastos-internos #ayc-dias').val() || 0;
		result = ((parseFloat(A) + parseFloat(C)) * parseFloat(dias) * (parseFloat(tec) + parseFloat(ls2)));
		$('#gastos-internos #ayc-tot').val(Math.round(result));
	}
/* Fin Gastos Internos */
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
            lastRow.find('td:last-child').append('<button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>');
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
	    $('#gastos-internos').on('input', 'input', function() {
        console.log('Cambio detectado en:', this);
        calculateHhd();
        calculateHhn();
        calculateGT();
        calculateBxZ();
        calculateAyC();
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
