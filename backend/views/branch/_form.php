<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Branch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idcompany')->dropDownList(
        ArrayHelper::map(\backend\models\Company::find()->all(), 'id', 'alias'),
        [
            'prompt' => 'Seleccione...',
        ]
    ) ?>

	<?= $form->field($model, 'idregion')->dropDownList(
        ArrayHelper::map(\backend\models\Region::find()->where(['idcountry' => 40])->all(), 'id', 'name'),
        [
            'prompt' => 'Seleccione...',
        ]
    ) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
