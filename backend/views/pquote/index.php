<?php

use backend\models\Pquote;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\PquoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cotizaciones';
$this->params['breadcrumbs'][] = $this->title;
# parche NUTZ
$idreq = $idreq ?? false;
?>
<div class="pquote-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<pre>

	</pre>
    <p>
        <?= Html::a('Ingresar Cotización', ['create'], ['class' => 'btn btn-success']) ?>
        <?php # = Html::a('Generar Presupuesto', ['gen', 'idreq' => base64_encode(Yii::$app->security->encryptByKey($idreq,Yii::$app->params['encryptionKey']))], ['class' => 'btn btn-success']) ?>
        <?php #= Html::a('Generar Presupuesto', ['gen', 'idreq' => $idreq], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'idreq',            
            'cost',
            [
            	'attribute' => 'idprovider',
            	'value' => function ($model) {
                	$result = $model->provider ? $model->provider->name : '(No definido)';
                	return ucwords($result);
            	},
            ],
            'valunt',
            'created_at',

            'selected',
            //'description:ntext',
            //'activities:ntext',

            //'payopt:ntext',
            //'exedr',
            //'exehr',
            //'tac:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pquote $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
