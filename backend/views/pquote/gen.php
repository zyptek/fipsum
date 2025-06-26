<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */

$this->title = "Generar Presupuesto: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pquote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # = Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* = Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este ítem?',
                'method' => 'post',
            ],
        ]) /**/?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
            	'attribute' => 'idprovider',
            	'label' => 'Cliente',
            	'value' => function($model){
	            	$result = $model->company ? $model->company->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
			[
            	'attribute' => 'idbranch',
            	'label' => 'Sucursal',
            	'value' => function($model){
	            	$result = $model->branch ? $model->branch->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],
/*
            [
            	'attribute' => 'mc',
            	'label' => "MC Sugerido",
            	'value' => function($model) use ($pquotes){
	            	foreach($pquotes as $pquote){
		            	$provider = $pquote->provider;
	            	}
	            	$result = $provider ? $provider->name : '(No definido)';
	            	return ucfirst($result);
            	}
            ],/**/
            [
            	'attribute' => 'mc',
            	'label' => "MC Sugerido",
            	'value' => function($model) use ($mc){
	            	return $mc->mc ."%";
            	}
            ],

/**/
		],
    ]) ?>
<?php $form = ActiveForm::begin(['action' => Url::to(['squote/new'])]); ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Costo</th>
                <th>Margen Contribución</th>
                <th>Selección</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pquotes as $item): ?>
                <tr data-id="<?= $item->id ?>">
                    <td><?= Html::tag('span',Html::encode($item->id), ['id' => 'selected-id']) ?></td>
                    <td><?= Html::encode($item->provider->name) ?></td>
                    <td><?= Html::encode("$".number_format(($item->cost),"0",",",".")) ?></td>
                    <td>
                        <input type="text" class="form-control mc" name="mc[<?= $item->id ?>]" value="<?= number_format(($item->cost *0.3),"0",",",".") ?>">
                    </td>
                    <td>
						<?= Html::radio("coti", false, ['value' => $item->id, 'class' => 'row-selector']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
	<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div id="btn1"><button type="submit" id="submit-button" class="btn btn-success">Generar Presupuesto</button></div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    // Detecta clic en el botón de envío deshabilitado
    $('#btn1').on('click', function(event) {
        if ($('input[name="coti"]:checked').length > 0) {
	    }else{
		    event.preventDefault();
            alert('Debe seleccionar una opción antes de continuar.');
        }
    });
    // Al cargar la página, desactiva el botón submit
//    $('#submit-button').prop('disabled', true);
        $('#button-submit').on('click', function(event) {
	        e.preventDefault();
	        alert('Debes seleccionar una opción antes de continuar.');
	    });
    // Escucha cambios en los radio buttons
    $('input[name="coti"]').on('change', function(e) {
        // Si hay un radio button seleccionado, activa el botón
        if ($('input[name="coti"]:checked').length > 0) {
//            $('#submit-button').prop('disabled', false);
        } else {

            // Si no hay ninguno seleccionado, desactiva el botón
//            $('#submit-button').prop('disabled', true);
        }
    });

});
JS
);
?>
