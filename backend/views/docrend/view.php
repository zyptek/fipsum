<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Docrend $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos Rendición', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="docrend-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Exportar', ['export-dr', 'id' => $model->id], ['class' => 'btn btn-dark', 'target' => '_blank',])?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'idreq',
            'assigned_amount',
            'expended_amount',
            'difference',
            'responsable',
            'presented_by',
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
<div class="dynamic-rows-form" style="line-height: 8px;">
    <table class="table table-bordered ppto" id="dynamic-table">
        <thead>
            <tr>
                <th>Fecha Emisión</th>
                <th>Ítem</th>
                <th>Proveedor</th>
                <th>Tipo Doc.</th>
                <th>Nº Doc</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
	        <?php foreach($details as $detail): ?>
            <tr>
                <td><input type="date" class="form-control" name="fecha" value="<?= $detail->date ?>" readonly /></td>
                <td><input type="text" class="form-control" name="detalle" value="<?= $detail->name ?>" readonly /></td>
                <td><input type="text" class="form-control" name="proveedor" value="<?= $detail->company ?>" readonly /></td>
                <td><input type="text" class="form-control" name="toe" value="<?= $detail->toe->name ?>" readonly /></td>
                <td><input type="text" class="form-control numberonly" name="no_doc"  value="<?= $detail->doc_no ?>" readonly /></td>
                <td><input type="text" class="form-control valor numberonly" name="valor"  value="<?= $detail->amount ?>" readonly /></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
<?php
	/*
		value="<?=	$model->expended_amount ?>" readonly
		value="<?=	$model->difference ?>" readonly
		value="<?=	$model->total ?>" readonly
		value="<?=	$model->idsolicitor ?>" readonly
		
		
/**/?>		
        <tfoot>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Facturas:</strong></td>
                <td><input type="input" class="form-control" name="cant-facturas" id="cant-facturas" value="<?=	$model->qty_facturas ?>" readonly /></td>
                <td  class="text-right" style="vertical-align: middle;"><strong>Total Facturas:</strong></td>
                <td><input type="input" class="form-control" name="total-facturas" id="total-facturas" value="<?=	$model->tot_facturas ?>" readonly /></td>
                <td></td>
            </tr>
            <tr>
	            <td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Boletas:</strong></td>
                <td><input type="input" class="form-control" name="cant-boletas" id="cant-boletas" value="<?=	$model->qty_boletas ?>" readonly /></td>
                <td class="text-right" style="vertical-align: middle;"><strong>Total Boletas:</strong></td>
                <td><input type="input" class="form-control" name="total-boletas" id="total-boletas" value="<?=	$model->tot_boletas ?>" readonly /></td>
                <td></td>
            </tr>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>Peajes:</strong></td>
                <td><input type="input" class="form-control" name="cant-peajes" id="cant-peajes" value="<?=	$model->qty_peajes ?>" readonly /></td>
                <td  class="text-right" style="vertical-align: middle;"><strong>Total Peajes:</strong></td>
                <td><input type="input" class="form-control" name="total-peajes" id="total-peajes" value="<?=	$model->tot_peajes ?>" readonly /></td>
                <td></td>
            </tr>
            <tr><td colspan="3" class="text-right" style="vertical-align: middle;"><strong>N. Crédito:</strong></td>
                <td><input type="input" class="form-control" name="cant-nc" id="cant-nc" value="<?=	$model->qty_nc ?>" readonly /></td>
                <td class="text-right" style="vertical-align: middle;"><strong>Total N. Crédito:</strong></td>
                <td><input type="input" class="form-control" name="total-nc" id="total-nc" value="<?=	$model->tot_nc ?>" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"class="text-right" style="vertical-align: middle;"><strong>Total General:</strong></td>
                <td><input type="input" class="form-control" name="grand-total" id="grand-total" value="<?=	$model->expended_amount ?>" readonly /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"class="text-right" style="vertical-align: middle;"><strong>Resultado/A Pagar:</strong></td>
                <td><input type="input" class="form-control" name="resultado" id="resultado" value="<?=	$model->difference ?>" readonly /></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

</div>