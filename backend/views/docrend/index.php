<?php

use backend\models\Docrend;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\DocrendSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Documentos Rendición';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docrend-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # = Html::a('Ingresar DR', ['new'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'idreq',
            'assigned_amount',
            'expended_amount',
            'difference',
            [
	            'attribute' => 'solicitor.email',
            ],
            //'total',
            //'responsable',
            //'presented_by',
            //'count_boletas',
            //'count_peajes',
            //'count_facturas',
            //'count_nc',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Docrend $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
