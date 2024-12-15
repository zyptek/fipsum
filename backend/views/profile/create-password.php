<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Crear Contraseña</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field(new \yii\base\DynamicModel(['password']), 'password')->passwordInput()->label('Nueva Contraseña') ?>

<?= Html::submitButton('Guardar Contraseña', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
