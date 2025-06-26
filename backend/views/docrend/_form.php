<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Docrend $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="docrend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreq')->textInput() ?>

    <?= $form->field($model, 'assigned_amount')->textInput() ?>

    <?= $form->field($model, 'expended_amount')->textInput() ?>

    <?= $form->field($model, 'difference')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'responsable')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presented_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count_boletas')->textInput() ?>

    <?= $form->field($model, 'count_peajes')->textInput() ?>

    <?= $form->field($model, 'count_facturas')->textInput() ?>

    <?= $form->field($model, 'count_nc')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
