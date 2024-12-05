<?php

use backend\models\Region;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\RegionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Regiones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Region', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],

#            'id',
#            'idcountry',
			[
	            'attribute' => 'idcountry', // El atributo relacionado
	            'value' => function ($model) {
	                return $model->country ? $model->country->name : '(No definido)';
	            },
	            'filter' => \yii\helpers\ArrayHelper::map(\backend\models\Country::find()->all(), 'id', 'name'), // Filtro desplegable
	        ],
            'name',
            'cod',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Region $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
