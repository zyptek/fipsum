<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\PquoteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pquote-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idprovider') ?>

    <?= $form->field($model, 'cost') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'idreq') ?>

    <?php // echo $form->field($model, 'selected') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'activities') ?>

    <?php // echo $form->field($model, 'valunt') ?>

    <?php // echo $form->field($model, 'payopt') ?>

    <?php // echo $form->field($model, 'exedr') ?>

    <?php // echo $form->field($model, 'exehr') ?>

    <?php // echo $form->field($model, 'tac') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
