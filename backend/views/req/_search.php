<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ReqSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="req-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nst') ?>

    <?= $form->field($model, 'nceco') ?>

    <?= $form->field($model, 'inidetail') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'estdays') ?>

    <?php // echo $form->field($model, 'idactivity') ?>

    <?php // echo $form->field($model, 'idtos') ?>

    <?php // echo $form->field($model, 'idstatus') ?>

    <?php // echo $form->field($model, 'idkam') ?>

    <?php // echo $form->field($model, 'idbranch') ?>

    <?php // echo $form->field($model, 'idsolicitor') ?>

    <?php // echo $form->field($model, 'idcompany') ?>

    <?php // echo $form->field($model, 'tecasigned') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
