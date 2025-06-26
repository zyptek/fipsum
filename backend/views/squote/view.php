<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Squote $model */

$this->title = "Presupuesto: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Squotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
#\yii\web\YiiAsset::register($this);
?>
<div class="squote-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Exportar', ['export', 'id' => $model->id], [
				'class' => 'btn btn-info',
				'target' => '_blank',
			]) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

</div>
<style>
table.ppto input{
	height:20px;
	vertical-align: middle;
}
</style>

<div class="details ppto" style="line-height: 8px;">
    <table class="table table-bordered ppto" id="dynamic-table">
        <thead>
            <tr>
                <th>Ítem</th>
                <th style="width: 50%">Detalle</th>
                <th>Unidad</th>
                <th>P. Unitario</th>
                <th>Cant.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
	        <?php foreach($model->squoteDetails as $detail): ?>
            <tr>
                <td><input type="text" class="form-control" value="<?= $detail['item']?>" readonly /></td>
                <td><input type="text" class="form-control" value="<?= $detail['descrip']?>" style="width: 100%;" title="<?= $detail['descrip']?>" readonly /></td>
                <td><input type="text" class="form-control" value="<?= $detail['unit']?>" readonly /></td>
                <td><input type="text" class="form-control" name="precio_unitario[]" value="<?= $detail['cost']?>" readonly /></td>
                <td><input type="text" class="form-control" value="<?= $detail['quant']?>" readonly /></td>
                <td><input type="text" class="form-control" value="<?= $detail['total']?>" readonly /></td>
            </tr>
             <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"  style="vertical-align: middle;"><strong>COSTO DIRECTO:</strong></td>
                <td><input type="input" class="form-control"  value="<?= $model->subtotal ?>"readonly /></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>GG 10% + U 10%:</strong></td>
                <td><input type="input" class="form-control" value="<?= $model->gg?>" readonly /></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>NETO:</strong></td>
                <td><input type="input" class="form-control" value="<?= $model->neto?>" readonly /></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>IVA:</strong></td>
                <td><input type="input" class="form-control" value="<?= $model->iva?>" readonly /></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle;"><strong>TOTAL:</strong></td>
                <td><input type="input" class="form-control" value="<?= $model->total?>" readonly /></td>
            </tr>
        </tfoot>
    </table>

</div>
