<?php

use backend\models\Solicitor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\SolicitorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Solicitante';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Solicitante', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

#            'id',
            'name',
            [
            	'attribute' => 'idcompany',
            	'value' => function ($model) {
                	$result = $model->company ? $model->company->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Solicitor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
