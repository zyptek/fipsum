<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var $tecnicos app\models\User[] */
/** @var $req app\models\Req */
?>
<pre>
	<?php
		
		print_r($tecnicos);
		
		?>
</pre>
<h1>Asignar Técnico</h1>

<?php $form = ActiveForm::begin(['action' => ['pquote/asignar', 'id' => $req->id]]); ?>

	<?= Html::dropDownList(
	    'id', // Nombre del campo
	    null, // Valor seleccionado
	    ArrayHelper::map($tecnicos, 'id', function ($model) {
			return $model->profile->name . ' ' . $model->profile->lastname;
		}), // Mapea 'id' y 'username' desde la lista de técnicos
	    ['prompt' => 'Seleccione un técnico'] // Placeholder inicial
	); ?>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
