<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;


/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */
$session = Yii::$app->session;
$role = $session->get('userRole');


$this->title = "Cotización: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pquote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
	<?php
		if($role >= 11){
	        echo Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
			echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]);
        } ?>
        <?= Html::a('Descargar OC', ['export', 'id' => $model->id], [
				'class' => 'btn btn-info',
				'target' => '_blank',
			]) ?>
		<?= Html::a('Consolidar', ['close', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'idreq',
			'description:ntext',
			'activities:ntext',
            [
            	'attribute' => 'idprovider',
            	'value' => function($model){
	            	$result = $model->provider ? $model->provider->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
			[
	            'attribute' => 'cost',
	            'label' => 'Neto',
	            'value' => function($model){
		            return "$" . number_format($model->cost,"0",",",".");
		         },
            ],
            [
	            'attribute' => 'cost',
	            'label' => 'IVA',
	            'value' => function($model){
		            return "$" . number_format(($model->cost * 0.19),"0",",",".");
		         },
            ],
			[
	            'attribute' => 'cost',
	            'label' => 'Total',
	            'value' => function($model){
		            return "$" . number_format(($model->cost * 1.19),"0",",",".");
		         },
            ],
            'valunt',
			[
				'attribute' => 'payopt:ntext',
				'label' => 'Opciones de Pago',
	            'value' => function($model){
	            	return "Transferencia Electronica - Abono 50%";
            	}
            ],
			[
				'attribute' => 'tac:ntext',
	            'label' => 'Términos y Condiciones',
	            'value' => function($model){
	            	return $model->payopt != "" ? $model->payopt : "Sin Información";
            	}
            ],
#            'selected',
#            'activities:ntext',
            
#            'payopt:ntext',
			[
				'attribute' => 'exedr',
	            'value' => function($model){
	            	return $model->exedr != "" ? $model->exedr : "Sin Información";
            	}
            ],
/*			[
				'attribute' => 'tac:ntext',
	            'value' => function($model){
	            	return $model->tac != "" ? $model->tac : "Sin Información";
            	}
            ],*/
        ],
    ]);
    
    Modal::begin([
	    'id' => 'assign-tec-modal',
	    'title' => '<h4>Asignar Técnico</h4>',
	    'footer' => Html::button('Cerrar', [
	        'class' => 'btn btn-secondary',
	        'data-dismiss' => 'modal',
	    ]) . ' ' . Html::submitButton('Asignar', [
	        'class' => 'btn btn-primary',
	        'form' => 'assign-tec-form', // ID del formulario
	    ]),
	    'closeButton' => [
	        'class' => 'btn-close',
	        'data-dismiss' => 'modal',
	        'aria-label' => 'Close',
	    ],
	]);
	
	// Formulario dentro del modal
	echo Html::beginForm(['pquote/tec', 'id' => $req->id], 'post', [
	    'id' => 'assign-tec-form',
	]);
	
	// Dropdown de técnicos
	echo Html::dropDownList(
	    'tecId', // Nombre del campo
	    null, // Valor seleccionado
	    ArrayHelper::map($tec, 'id', function ($model) {
	        return $model->profile 
	            ? $model->profile->name . ' ' . $model->profile->lastname 
	            : 'Sin perfil'; // Fallback
	    }),
	    ['class' => 'form-control', 'prompt' => 'Seleccione un técnico']
	);
	
	echo Html::endForm();
	
	// Cerrar el modal
	Modal::end();
    
    ?>

</div>
