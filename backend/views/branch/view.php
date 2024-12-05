<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Branch $model */

$this->title = "Sucursal: " . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sucursales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
            	'attribute' => 'idcompany',
            	'value' => function ($model) {
                	$result = $model->company ? $model->company->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            [
            	'attribute' => 'idregiony',
            	'value' => function ($model) {
                	$result = $model->region ? $model->region->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            'city',
            'address',
        ],
    ]) ?>

</div>
