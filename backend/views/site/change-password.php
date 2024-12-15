<?php
	
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Crear Contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="change-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <h2>Por favor cree su contraseña para ingresar al sistema</h2>
    <div class="password-form">
        <?php $form = ActiveForm::begin([
	        'method' => 'post',
	        ]); ?>

        <?= $form->field($model, 'newPassword')->passwordInput()->label('Contraseña') ?>
        <?= $form->field($model, 'confirmPassword')->passwordInput()->label('Confirme Contraseña') ?>

        <div class="form-group">
            <?= Html::submitButton('Actualizar Contraseña', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
