<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Company $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branches')->textInput() ?>

    <?= $form->field($model, 'idregion')->dropDownList(
        ArrayHelper::map(\backend\models\Region::find()->where(['idcountry' => 40])->all(), 'id', 'name'),
        [
            'prompt' => 'Seleccione...',
        ]
    ) ?>

    <?= $form->field($model, 'active')->radioList([
    0 => 'Inactivo', 
    1 => 'Activo'
    ])->label('Visibilidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
