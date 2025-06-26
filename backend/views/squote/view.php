<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Squote $model */

$this->title = "Presupuesto: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
#\yii\web\YiiAsset::register($this);
?>
<pre>
<?php
		echo($model->noc);
?>
</pre>
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
	        'idreq',
/*
	        [
		        'attribute' => 'id',
		        'label' => 'Presupuesto',
	        ],
*/
/*
            [
            	'attribute' => 'idpquote',
            	'label' => 'Cotización',
            ],
*/
            [
            	'attribute' => 'cliente.alias',
            	'label' => 'Cliente',
            ],
            [
            	'attribute' => 'branch.name',
            	'label' => 'Sucursal',
            ],
			'created_at',
        ],
    ]) ?>

</div>
<style>
table.ppto input{
	height:20px;
	vertical-align: middle;
}
table.ppto button{
	padding:5px;
	border-radius:20px;
}	
</style>
<div>
<h2>Costos Informados</h2>
<table class="table table-bordered ppto" id="gastos-internos"><thead>
  <tr>
    <th class="" colspan="6" style="background-color: #6796e5; color:white;">Materiales</th>
  </tr></thead>
<tbody>
  <tr>
    <td class=""><input type="text" class="form-control numberonly" id="mat-tot" value="<?= isset($model->squoteprivate['mat-tot']) ? $model->squoteprivate['mat-tot'] : "" ?>" readonly /></td>
    <td class="" colspan="5"><input type="text" class="form-control" id="mat-desc" value="<?= isset($model->squoteprivate['mat-desc']) ? $model->squoteprivate['mat-desc'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="background-color: #6796e5; color:white;"></td>
    <td class="" style="background-color: #6796e5; color:white; font-weight: 700">HHD</td>
    <td class="" colspan="1" style="background-color: #6796e5; color:white; font-weight: 700">HHN</td>
    <td class="" colspan="3" style="background-color: #6796e5; color:white; font-weight: 700">Gastos Traslados</td>

  </tr>
  <tr>
    <td class="" style="font-weight: 700">Técnicos</td>
    <td class=""><input type="text" class="form-control numberonly" id="hhd-tec" value="<?= isset($model->squoteprivate['hhd-tec']) ? $model->squoteprivate['hhd-tec'] : "" ?>" readonly /></td>
    <td class="" colspan="1"><input type="text" class="form-control" id="hhn-tec" value="<?= isset($model->squoteprivate['hhn-tec']) ? $model->squoteprivate['hhn-tec'] : "" ?>" readonly /></td>
    <td class="" colspan="2" style="font-weight: 700">Peajes</td>
    <td class=""><input type="text" class="form-control numberonly" id="gt-peaje" value="<?= isset($model->squoteprivate['gt-peaje']) ? $model->squoteprivate['gt-peaje'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">LS2</td>
    <td class=""><input type="text" class="form-control numberonly" id="hhd-ls2" value="<?= isset($model->squoteprivate['hhd-ls2']) ? $model->squoteprivate['hhd-ls2'] : "" ?>" readonly /></td>
    <td class="" colspan="1"><input type="text" class="form-control" id="hhn-ls2" value="<?= isset($model->squoteprivate['hhn-ls2']) ? $model->squoteprivate['hhn-ls2'] : "" ?>" readonly /></td>
    <td class="" colspan="2" style="font-weight: 700">Estacionamiento</td>
    <td class=""><input type="text" class="form-control numberonly" id="gt-estac" value="<?= isset($model->squoteprivate['gt-estac']) ? $model->squoteprivate['gt-estac'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Días</td>
    <td class=""><input type="text" class="form-control numberonly" id="hhd-dias" value="<?= isset($model->squoteprivate['hhd-dias']) ? $model->squoteprivate['hhd-dias'] : "" ?>" readonly /></td>
    <td class="" colspan="1"><input type="text" class="form-control" id="hhn-dias" value="<?= isset($model->squoteprivate['hhn-dias']) ? $model->squoteprivate['hhn-dias'] : "" ?>" readonly /></td>
    <td class="" colspan="2" style="font-weight: 700">Kms</td>
    <td class=""><input type="text" class="form-control numberonly" id="gt-km" value="<?= isset($model->squoteprivate['gt-km']) ? $model->squoteprivate['gt-km'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Total</td>
    <td class=""><input type="text" class="form-control numberonly" id="hhd-tot" value="<?= isset($model->squoteprivate['hhd-tot']) ? $model->squoteprivate['hhd-tot'] : "" ?>" readonly /></td>
    <td class="" colspan="1"><input type="text" class="form-control" id="hhn-tot" value="<?= isset($model->squoteprivate['hhn-tot']) ? $model->squoteprivate['hhn-tot'] : "" ?>" readonly /></td>
    <td class="" colspan="2" style="font-weight: 700">Total</td>
    <td class=""><input type="text" class="form-control numberonly" id="gt-tot" value="<?= isset($model->squoteprivate['gt-tot']) ? $model->squoteprivate['gt-tot'] : "" ?>" readonly /></td>

  </tr>
  <tr>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Bono Por Zona</td>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Alojamiento y Colaciones</td>
    <td class="" colspan="2" style="background-color: #6796e5; color:white; font-weight: 700">Resumen</td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Técnicos</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['bxz-tec']) ? $model->squoteprivate['bxz-tec'] : "" ?>" readonly /></td>
    <td class="" style="font-weight: 700">Alojamiento</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['ayc-aloj']) ? $model->squoteprivate['ayc-aloj'] : "" ?>" readonly /></td>
    <td style="font-weight: 700">Total</td>
    <td><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['rtotal']) ? $model->squoteprivate['rtotal'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">LS2</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['bxz-ls2']) ? $model->squoteprivate['bxz-ls2'] : "" ?>" readonly /></td>
    <td class="" style="font-weight: 700">Colaciones</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['ayc-col']) ? $model->squoteprivate['ayc-col'] : "" ?>" readonly /></td>
	<td style="font-weight: 700">MC %</td>
	<td><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['mcpct']) ? $model->squoteprivate['mcpct'] : ($const->mc * 100) ?>" readonly /> </td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Días</td>
    <td class="" colspan="1" ><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['bxz-dias']) ? $model->squoteprivate['bxz-dias'] : "" ?>" readonly /></td>
    <td class="" style="font-weight: 700">Días</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['ayc-dias']) ? $model->squoteprivate['ayc-dias'] : "" ?>" readonly /></td>
	<td style="font-weight: 700">MC $</td>
	<td><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['mc']) ? $model->squoteprivate['mc'] : "" ?>" readonly /></td>
  </tr>
  <tr>
    <td class="" style="font-weight: 700">Total</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['bxz-tot']) ? $model->squoteprivate['bxz-tot'] : "" ?>"  readonly /></td>
    <td class="" style="font-weight: 700">Total</td>
    <td class="" colspan="1"><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['ayc-tot']) ? $model->squoteprivate['ayc-tot'] : "" ?>"  readonly /></td>
    <td style="font-weight: 700">Venta Costo</td>
    <td><input type="text" class="form-control numberonly" value="<?= isset($model->squoteprivate['ven-cos']) ? $model->squoteprivate['ven-cos'] : "" ?>"  readonly /></td>
  </tr></tbody></table>
</div>
<h2>Presupuesto</h2>
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
                <td><input type="text" class="form-control" value="<?= $detail['cost']?>" readonly /></td>
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
