<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DocrendSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="docrend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idreq') ?>

    <?= $form->field($model, 'assigned_amount') ?>

    <?= $form->field($model, 'expended_amount') ?>

    <?= $form->field($model, 'difference') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'responsable') ?>

    <?php // echo $form->field($model, 'presented_by') ?>

    <?php // echo $form->field($model, 'count_boletas') ?>

    <?php // echo $form->field($model, 'count_peajes') ?>

    <?php // echo $form->field($model, 'count_facturas') ?>

    <?php // echo $form->field($model, 'count_nc') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
