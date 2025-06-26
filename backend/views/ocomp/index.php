<?php

use backend\models\Ocomp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\OcompSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Órdenes de Compra';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ocomp-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Orden', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'noc',
            'idtop',
            'idvop',
            'idreq',
            //'iduser',
            //'idprovider',
            //'subtotal',
            //'neto',
            //'iva',
            //'total',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Ocomp $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
