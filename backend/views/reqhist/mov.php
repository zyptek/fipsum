<?php

use backend\models\Reqhist;
use backend\models\ReqhistSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/** @var yii\web\View $this */
/** @var backend\models\ReqhistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (isset($reqid)) {
#	$searchModel = new ReqhistSearch();
	$dataProvider = new ActiveDataProvider([
	    'query' => Reqhist::find()->where(['idreq' => $reqid])->orderBy(['id' => SORT_DESC]),
	    'pagination' => [
	        'pageSize' => 10,
	    ],
	]);
}



?>
<div class="reqhist-index">

    <h3><?= Html::encode('Historial de Movimientos de Requerimiento') ?></h3>

<!--
    <p>
        <?= Html::a('Crear Movimiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
#        'filterModel' => $searchModel,
        'columns' => [
#            ['class' => 'yii\grid\SerialColumn'],

#            'id',
#            'idreq',
			[
	            'attribute' => 'idhisttype',
	            'value' => function($model) {
                	$result = $model->histtype ? $model->histtype->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            'created_at',
#            'iduser',
            'detail',
            
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
