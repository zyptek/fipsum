<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Alloc $model */

$session = Yii::$app->session;
$role = $session->get('userRole');

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => isset($idreq) ? ['index', 'idreq' => $idreq] : ['index']];
$this->params['breadcrumbs'][] = $this->title;
# \yii\web\YiiAsset::register($this);
?>
<div class="alloc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
		
        <?php
	        if($role == 8 || $role == 10 || $role == 11){
		        if(($model->idstatus == 2 && $model->amount >= 100000) || ($model->idstatus == 1) || ($role > 11)){
					echo Html::a('Aprobar', ['aprove', 'id' => $model->id], ['class' => 'btn btn-success']);
				}
			}
		?>
        <?php if(($role == 3 || $role > 11)): ?>

        <?= Html::a('Registrar Pagado', ['paid', 'id' => $model->id], [
            'class' => ($model->idstatus == 3) ? 'btn btn-success' : 'btn btn-success disabled',
            'data' => [
                'confirm' => '¿Seguro desea cambiar estado a "Pagado"?',
                'method' => 'post',
            ],
            
        ]) ?>
        <?= Html::a('Volver a Req', ['req/view', 'id' => $model->req->id], ['class' => 'btn btn-info']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
#            'id',
            [
            	'attribute' =>'idreq',
            	'value' => function($data){
	            	return $data->req->id;
            	}
            ],
            [
            	'attribute' =>'profile.name',
            	'label' => 'Gestor',
            	'value' => function($data){
	            	return $data->profile->name . " " . $data->profile->lastname;
            	}
            ],
            [
            	'attribute' =>'profile.name',
            	'label' => 'Solicitante',
            	'value' => function($data){
	            	return $data->solicitorProfile->name . " " . $data->solicitorProfile->lastname;
            	}
            ],
            'amount',
            [
            	'attribute' =>'idtoa',
            	'value' => function($data){
	            	return $data->toa->name;
            	}
            ],
            'description:ntext',
            [
            	'attribute' => 'created_at',
            	'value' => function($model){
	            	return substr($model->created_at, 0, 16);
            	}
            ],
            [
            	'attribute' => 'idstatus',
            	'value' => function($model){
	            	return $model->status->name;
            	}
            ],
        ],
    ]) ?>

</div>
