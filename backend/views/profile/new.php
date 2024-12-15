<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Profile $model */

$this->title = 'Crear Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-new">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="profile-form">
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        

        <?= $form->field($model, 'idrole')->dropDownList(
        ArrayHelper::map(\backend\models\Role::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Seleccione...',
        ]
		)?>

        <div class="form-group">
            <?= Html::submitButton('Crear Usuario', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

</div>
