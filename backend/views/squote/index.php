<?php

use backend\models\Squote;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\SquoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Presupuestos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squote-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Presupuesto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



	<pre><?php /*
		if(isset($data)){
			print_r($data);
		} /**/
		?></pre>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],
            'id',
#            'cm',
#            'cmp',
			[
	        	'label' => 'Nº IT',
	        	'attribute' => 'idreq',
	        	'value' => function($model){
		        	$result = $model->req ? $model->req->id : '(No definido)';
	            	return ucfirst($result);
	        	},
	            
            ],
            [
	        	'label' => 'Cliente',
	        	'value' => function($model){
		        	$result = $model->cliente ? $model->cliente->alias : '(No definido)';
	            	return ucfirst($result);
	        	},
	            
            ],
            [
            	'attribute' => 'created_at',
            	'label' => 'Fecha',
            ],
            [
            	'attribute' => 'mc',
            	'label' => 'MC',
            ],
            'total',
            //'accepted',
            //'author_accepted',
            //'date_accepted',
            //'approved_f',
            //'approved_c',
            //'idreq',
            //'idpquote',
/*
            [
	        	'label' => 'Owner',
	        	'value' => function($model){
		        	$result = $model->req->user->profile->name ?? '(No Owner)';
	            	return ucfirst($result);
	        	},
	            
            ],
*/
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Squote $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
