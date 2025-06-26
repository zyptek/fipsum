<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Solicitor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="solicitor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idcompany')->dropDownList(
        ArrayHelper::map(\backend\models\Company::find()->all(), 'id', 'alias'),
        [
            'prompt' => 'Seleccione...',
            'id' => 'select-company', // ID para manejar con JS
        ]
    ) ?>    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
