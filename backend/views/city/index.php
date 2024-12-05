<?php

use backend\models\City;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\CitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ciudades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Ciudad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],

#            'id',
            'name',
            [
	            'attribute' => 'idcountry',
	            'label' => "País",
            	'content' => function ($model) {
	            	if(isset($model->country)){
			            return Html::a($model->country->name,['country/view','id' => $model->country->id]);
						#return Html::a(Html::encode($data->country->name),"/country/view?id=$data->idcountry");
					}else if(!isset($model->country->name) && isset($model->country)){
						return Html::a($model->country,['country/view','id' => $model->country]);
						#return Html::a(Html::encode($data->idcountry),"/country/view?id=$data->idcountry");
					}else{
						return '<span class="not-set" style="font-size: 14px !important; line-height: 21px !important;">(No Definido)</span>';
					}
                	#return $model->country ? $model->country->name : '(No definido)';
            	},
            ],
#            'idregion',
#            'updated_at',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, City $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
