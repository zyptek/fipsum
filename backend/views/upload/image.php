<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subir Imagen';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="image-upload">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
