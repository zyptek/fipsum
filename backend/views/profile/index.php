<?php

use backend\models\Profile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use hail812\adminlte\widgets\Alert;
/** @var yii\web\View $this */
/** @var backend\models\ProfileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$titulos = Yii::$app->params['alertTitles'] ?? [];

foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
    // Asegúrate de que el tipo de mensaje sea válido para el widget Alert
    if (in_array($type, ['success', 'info', 'danger', 'warning'], true)) {
        echo Alert::widget([
            'type' => $type, // Asigna dinámicamente el tipo de alerta
            'body' => $message, // Muestra el mensaje correspondiente
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

#            'id',
			[
				'attribute' => 'iduser',
				'label' => 'E-mail',
				'value' => function ($model) {
		            $result = $model->user ? $model->user->email : '(No definido)';
                	return ucwords($result);
                }
			],
            'name',
            'lastname',
#            'iduser',
			[
				'attribute' => 'idrole',
				'value' => function ($model) {
		            $result = $model->role ? $model->role->name : '(No definido)';
                	return ucwords($result);
                }
			],
            'created_at',
            //'updated_at',
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
