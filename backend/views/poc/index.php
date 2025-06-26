<?php

use backend\models\Poc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\PocSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ordenes de Compra';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # = Html::a('Create Poc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'noc',
            'idtop',
            'idvop',
            'idreq',
            'iduser',
            //'idprovider',
            //'noc',
            //'descrip',
            //'subtotal',
            //'neto',
            //'iva',
            //'total',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Poc $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
