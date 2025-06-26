<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\PocSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="poc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idtop') ?>

    <?= $form->field($model, 'idvop') ?>

    <?= $form->field($model, 'idreq') ?>

    <?= $form->field($model, 'iduser') ?>

    <?php // echo $form->field($model, 'idprovider') ?>

    <?php // echo $form->field($model, 'noc') ?>

    <?php // echo $form->field($model, 'descrip') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'neto') ?>

    <?php // echo $form->field($model, 'iva') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
