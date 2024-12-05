<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\ImageGalleryWidget;


/** @var yii\web\View $this */
/** @var backend\models\Req $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requerimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="req-view">

    <h1><?= Html::encode("Requerimiento: " . $this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de que desea eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Exportar', ['export-word', 'id' => $model->id], [
    'class' => 'btn btn-info',
    'target' => '_blank',
])?>
    <?= Html::a('Solicitar Cotización', ['quote', 'id' => $model->id], ['class' => 'btn btn-warning'])?>   
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'idalt',
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
            'estdays',
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
            [
            	'attribute' => 'created_at',
            	'value' => function($model){
	            	return substr($model->created_at, 0, 16);
            	}
            ]
        ],
    ]) ?>

</div>
<h3>Imágenes</h3>
<?php
	echo ImageGalleryWidget::widget([
    'relatedId' => $model->id, // ID del modelo actual
    'relatedModel' => 'req', // Nombre de la tabla
]);
?>
<!-- <h3>Historial de Movimientos de Requerimientos</h3> -->
<?= $this->render('//reqhist/mov', ['reqid' => $model->id]) ?>

