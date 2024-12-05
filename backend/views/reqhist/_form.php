<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Reqhist $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reqhist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreq')->textInput() ?>

    <?= $form->field($model, 'idhisttype')->textInput() ?>

    <?= $form->field($model, 'iduser')->textInput() ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
