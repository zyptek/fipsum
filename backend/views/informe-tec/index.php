<?php

use backend\models\Inftec;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\InftecSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Informes Técnicos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="inftec-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Informe', ['create'], ['class' => 'btn btn-success']) ?>
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
            	'attribute' => 'detalle',
            	'format' => 'html',
            	'value' => function ($model) {
			        return \yii\helpers\StringHelper::truncate(strip_tags($model->detalle), 100);
			    },
            ],
            'created_at:date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Inftec $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
