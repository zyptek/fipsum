<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Inftec $model */

$this->title = "Informe: " . $model->idreq;
$this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inftec-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro desea eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Export', ['exportx', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
#            'id',
            'idreq',
            [
            	'attribute' => 'detalle',
            	'format' => 'html',
            	'value' => function ($model) {
			        return \yii\helpers\StringHelper::truncate(strip_tags($model->detalle), 100);
			    },
            ],
            'created_at:date',
        ],
    ]) ?>

</div>
