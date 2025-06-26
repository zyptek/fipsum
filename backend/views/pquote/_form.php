<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pquote-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idprovider')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'idreq')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'activities')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'valunt')->textInput([
        'type' => 'date',
        'class' => 'form-control',
    ]) ?>

    <?= $form->field($model, 'payopt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'exedr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exehr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tac')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
