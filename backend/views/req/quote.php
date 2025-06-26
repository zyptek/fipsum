<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\ImageGalleryWidget;

$providerList = \yii\helpers\ArrayHelper::map($providers, 'id', 'name');

#$providerList =[0 => "ElectriFast", 1 => "SuperElec", 2 => "FastVal"];

/** @var yii\web\View $this */
/** @var backend\models\Req $model */

$this->title = "Solicitar Cotización: " . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requerimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="req-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de que desea eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a('Ingresar Cotización', ['pquote/create', 'idreq' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

<h3>Información General</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
#            'nst',
			[
            	'attribute' => 'idcompany',
            	'value' => function(){
	            	return ucfirst("CL");
            	}
            ],
            [
            	'attribute' => 'idbranch',
            	'value' => function($model){
	            	$result = $model->branch ? $model->branch->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idsolicitor',
            	'value' => function($model){
	            	$result = $model->solicitor ? $model->solicitor->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idtos',
            	'value' => function($model){
	            	$result = $model->tos ? $model->tos->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idactivity',
            	'value' => function($model){
	            	$result = $model->activity ? $model->activity->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
#            'estdays',
            'inidetail:ntext',
            'description:ntext',
            [
            	'attribute' => 'idstatus',
            	'value' => function($model){
	            	$result = $model->status ? $model->status->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idkam',
            	'value' => function(){
	            	return "Fernanda Rosas";
            	}
            ],
            'created_at',
        ],
    ]) ?>
    
    <h3>Seleccione Proveedores</h3>
    <?= Html::beginForm(['req/quote', 'id' => $model->id], 'post') ?>

    <?= Html::checkboxList('selectedProviders', [], $providerList, [
        'itemOptions' => [
            'class' => 'provider-checkbox'
        ],
    ]) ?>

    <div class="form-group">
	    <?php $submitText = (count($pQuotes) > 0) ? "Re-Solicitar Cotizaciónes" : "Solicitar Cotización"; ?>
        <?= Html::submitButton($submitText, ['class' => 'btn btn-success']) ?>
        <?php if(count($pQuotes) > 0): ?>
        <?= Html::a('Ver Cotizaciones Solicitadas', ['pquote/index', 'idreq' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?= Html::endForm() ?>

</div>


