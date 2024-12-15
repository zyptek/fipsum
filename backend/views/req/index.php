<?php

use backend\models\Req;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use PhpOffice\PhpWord\TemplateProcessor;
use yii\web\NotFoundHttpException;
/** @var yii\web\View $this */
/** @var backend\models\ReqSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Requerimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="req-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Requerimiento', ['create'], ['class' => 'btn btn-success']) ?>
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
	            'attribute' => 'idbranch',
	            'value' => function ($model) {
		            $company = $model->company ? $model->company->alias : '(No definido)';
                	$branch = $model->branch ? $model->branch->name : '(No definido)';
                	$result = $company . "/" . $branch;
                	return ucwords($result);
            	},
            ],
            [
	            'attribute' => 'idstatus',
	            'value' => function ($model) {
                	$result = $model->status ? $model->status->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            'id',
            [
	            'attribute' => 'idtos',
	            'value' => function ($model) {
                	$result = $model->tos ? $model->tos->name : '(No definido)';
                	return ucwords($result);
            	},
            ],	
            [
	            'attribute' => 'idactivity',
	            'value' => function ($model) {
                	$result = $model->activity ? $model->activity->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            [
	            'attribute' => 'idsolicitor',
	            'value' => function ($model) {
                	$result =	 $model->solicitor ? $model->solicitor->name : '(No definido)';
                	return ucwords($result);
            	},
            ],	
            'estdays',
            [
            	'attribute' => 'created_at',
            	'value' => function($model){
	            	return substr($model->created_at, 0, 16);
            	}
            ],
            [
	            'attribute' => 'created_at',
	            'label' => 'Tiempo',
            	'value' => function($model){
	            	$fechaOriginal = new DateTime($model->created_at);
	            	$fechaActual = new DateTime();
	            	$dif = $fechaActual->diff($fechaOriginal);
	            	$dias = $dif->days;
					$horas = $dif->h;
					if($dias > 0){
						return "$dias día(s) y $horas hora(s)";
					}else{
						return "$horas hora(s)";
					}
	            	
            	}
            ],
#            'idalt',
#            'inidetail:ntext',
#            'description:ntext',
#            'idkam',
#            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Req $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
