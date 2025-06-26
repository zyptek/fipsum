<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\SquoteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="squote-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mc') ?>

    <?= $form->field($model, 'cmp') ?>

    <?= $form->field($model, 'subtotal') ?>

    <?= $form->field($model, 'gg') ?>

    <?php // echo $form->field($model, 'neto') ?>

    <?php // echo $form->field($model, 'iva') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'accepted') ?>

    <?php // echo $form->field($model, 'author_accepted') ?>

    <?php // echo $form->field($model, 'date_accepted') ?>

    <?php // echo $form->field($model, 'approved_f') ?>

    <?php // echo $form->field($model, 'approved_c') ?>

    <?php // echo $form->field($model, 'idreq') ?>

    <?php // echo $form->field($model, 'idpquote') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
