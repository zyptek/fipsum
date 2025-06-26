<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Ocomp $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ocomp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'noc')->textInput() ?>

    <?= $form->field($model, 'idtop')->textInput() ?>

    <?= $form->field($model, 'idvop')->textInput() ?>

    <?= $form->field($model, 'idreq')->textInput() ?>

    <?= $form->field($model, 'iduser')->textInput() ?>

    <?= $form->field($model, 'idprovider')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <?= $form->field($model, 'neto')->textInput() ?>

    <?= $form->field($model, 'iva')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
