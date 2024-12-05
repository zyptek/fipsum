<?php

use backend\models\Branch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\BranchSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sucursal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Sucursal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],

 #           'id',
            'name',
            [
            	'attribute' => 'idcompany',
            	'value' => function ($model) {
                	$result = $model->company ? $model->company->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            [
            	'attribute' => 'idregion',
            	'value' => function ($model) {
                	$result = $model->region ? $model->region->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            'city',
            //'address',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Branch $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
