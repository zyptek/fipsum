<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Squote $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
table.ppto input{
	height:30px;
	vertical-align: middle;
}
table.ppto button{
	padding:5px;
	border-radius:20px;
}	
</style>
<div class="squote-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mc')->textInput() ?>

    <?= $form->field($model, 'cmp')->textInput() ?>

    <?= $form->field($model, 'accepted')->textInput() ?>

    <?= $form->field($model, 'author_accepted')->textInput() ?>

    <?= $form->field($model, 'date_accepted')->textInput() ?>

    <?= $form->field($model, 'approved_f')->textInput() ?>

    <?= $form->field($model, 'approved_c')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
