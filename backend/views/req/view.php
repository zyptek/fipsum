<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\ImageGalleryWidget;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Modal;

$session = Yii::$app->session;
$role = $session->get('userRole');

$hasRend = \backend\models\Docrend::find()->where(['idreq' => $model->id])->andWhere(['idsolicitor' => Yii::$app->user->id ])->one();

/** @var yii\web\View $this */
/** @var backend\models\Req $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requerimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
#\yii\web\YiiAsset::register($this);
?>

<div class="req-view">

    <h1><?= Html::encode("Requerimiento: " . $this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => /*base64_encode(Yii::$app->security->encryptByKey(*/$model->id/*,Yii::$app->params['encryptionKey']))*/], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Anular', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de que desea anular este requerimiento?',
                'method' => 'post',
            ],
        ]) ?>
        
    <?= Html::a('Cotización', ['quote', 'id' => $model->id], ['class' => 'btn btn-warning'])?>
    <?php
	    if(count($pquotes) > 0){
		    echo Html::a('Presupuesto', ['squote/new', 'idreq' => $model->id], ['class' => 'btn btn-warning']);
	    }
	    echo " ";
	    if (($role >= 7 || $role <= 9) || $role > 11) {
			echo Html::a('Asignaciones', ['alloc/index', 'idreq' => $model->id], ['class' => 'btn btn-secondary']);
			
		}
		echo " ";
		if ($hasRend || $role > 1) {
			echo Html::a('Llenar DR', ['docrend/new', 'idreq' => $model->id], ['class' => 'btn btn-secondary']);
			
		}
	?>
	<?php if ($role > 5 ): ?>

    <?php endif; ?>
    <?php if($role != 6){
	    echo Html::button('Asignar Técnico', [
	        'id' => $model->id,
	        'class' => 'btn btn-info',
	        'data-toggle' => 'modal',
			'data-target' => '#assign-tec-modal',
	        ]);
	    }
	    ?>
	<?= Html::a('Cerrar Req', ['close', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de que desea cerrar este requerimiento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nst',
            [
            	'attribute' => 'nceco',
            	'value' => function($model){
	            	$result = $model->nceco ? $model->nceco : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
			[
            	'attribute' => 'idcompany',
            	'value' => function($model){
	            	$result = $model->company ? $model->company->alias : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idbranch',
            	'value' => function($model){
	            	$result = $model->branch ? $model->branch->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idsolicitor',
            	'value' => function($model){
	            	$result = $model->solicitor ? $model->solicitor->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idtos',
            	'value' => function($model){
	            	$result = $model->tos ? $model->tos->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idactivity',
            	'value' => function($model){
	            	$result = $model->activity ? $model->activity->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            'estdays',
            'inidetail:ntext',
            'description:ntext',
            [
            	'attribute' => 'idstatus',
            	'value' => function($model){
	            	$result = $model->status ? $model->status->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
            [
            	'attribute' => 'idkam',
            	'value' => function(){
	            	return "Fernanda Rosas";
            	}
            ],
            [
            	'attribute' => 'created_at',
            	'value' => function($model){
	            	return substr($model->created_at, 0, 16);
            	}
            ]
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
	echo Html::beginForm(['tec', 'id' => $model->id], 'post', [
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
<h3>Documentos</h3>
<?php
	echo ImageGalleryWidget::widget([
    'relatedId' => $model->id, // ID del modelo actual
    'relatedModel' => 'req', // Nombre de la tabla
    'type' => 'doc',
]);
?>
<h3>Imágenes</h3>
<?php
	echo ImageGalleryWidget::widget([
    'relatedId' => $model->id, // ID del modelo actual
    'relatedModel' => 'req', // Nombre de la tabla
    'type' => 'img',

]);
?>
<!-- <h3>Historial de Movimientos de Requerimientos</h3> -->
<?= $this->render('//reqhist/mov', ['reqid' => $model->id]) ?>

