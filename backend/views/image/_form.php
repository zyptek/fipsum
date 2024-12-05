<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Image $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'path')->fileInput() ?>

    <?php #= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?php #= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?php #= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?php #= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
