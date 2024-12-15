<?php

use backend\models\Reqhist;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\ReqhistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Historial de Movimientos de Requerimiento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reqhist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Registro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],

#            'id',
            [
            	'attribute' => 'idreq',
            	'label' => 'Requerimiento',
            	
            ],
            [
            	'attribute' => 'idhisttype',
            	'value' => function ($model) {
                	$result = $model->histtype ? $model->histtype->name : '(No definido)';
                	return ucwords($result);
            	},
            ],

            [
		        'attribute' => 'profile.name',

		        'value' => function ($model) {
		            return $model->profile ? $model->profile->name : '(Sin perfil)';
		        }
		    ],
			[
				'attribute' => 'iduser',
				'label' => 'Autor',
				'value' => function(){
					return 'Fernanda Rozas';
				},
			],
            
            'detail',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reqhist $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
