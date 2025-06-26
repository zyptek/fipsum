<?php

use backend\models\Profile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
#use hail812\adminlte\widgets\Alert;
use backend\components\CustomAlert as Alert;


/** @var yii\web\View $this */
/** @var backend\models\ProfileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
    if (in_array($type, ['success', 'info', 'danger', 'warning'], true)) {
        echo Alert::widget([
            'type' => $type,
            'body' => $message,
        ]);
    }
}

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Usuario', ['new'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
			    'attribute' => 'eMail',
			    'value' => 'user.email',
			    'filter' => Html::activeTextInput($searchModel, 'eMail', [
			        'class' => 'form-control'
			    ]),
			],
            'name',
            'lastname',
#            'iduser',
			[
			    'attribute' => 'roleName',
			    'value' => 'role.name',
			    'filter' => Html::activeTextInput($searchModel, 'roleName', [
			        'class' => 'form-control'
			    ]),
			],

			[
			    'attribute' => 'created_at',
			    'value' => 'created_at',
			    'format' => ['date', 'php:Y-m-d'], // o simplemente 'text'
			    'filter' => Html::beginTag('div', ['style' => 'display:flex; gap:4px; flex-direction:column']) .
			        Html::activeInput('date', $searchModel, 'created_from', ['class' => 'form-control', 'placeholder' => 'Desde']) .
			        Html::activeInput('date', $searchModel, 'created_to', ['class' => 'form-control', 'placeholder' => 'Hasta']) .
			        Html::endTag('div'),
			],
			
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Profile $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
