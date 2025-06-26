<?php

use backend\models\Alloc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\AllocSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Asignaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alloc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
	        if(isset($idreq)) echo Html::a('Registrar Asignación', ['new', 'idreq' => $idreq], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
#            'id',
            'idreq',
            [
            	'attribute' =>'iduser',
            	'label' => 'Gestor',
            	'value' => function($data){
	            	return $data->profile ? $data->profile->name . " " . $data->profile->lastname : "No definido";
            	},
#            	'headerOptions' => ['style' => 'width: 200px;'],
            ],
            [
            	'attribute' =>'idsolicitor',
            	'label' => 'Solicitante',
            	'value' => function($data){
	            	return $data->solicitorProfile ? $data->solicitorProfile->name . " " . $data->solicitorProfile->lastname : "No definido";
            	},
#            	'headerOptions' => ['style' => 'width: 200px;'],
            ],

            'amount',
            //'idtoa',
            [
            	'attribute' =>'idtoa',
            	'value' => function($data){
	            	return $data->toa ? $data->toa->name : "No definido";
            	},
#            	'headerOptions' => ['style' => 'width: 200px;'],
            ],
            //'description:ntext',
            //'created_at',
            [
            	'attribute' => 'status',
            	'value' => function($model){
	            	return $model->status->name;
            	},
#            	'headerOptions' => ['style' => 'width: 200px;']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Alloc $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'idreq' => $model->idreq]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
