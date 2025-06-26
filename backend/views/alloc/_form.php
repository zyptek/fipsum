<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Alloc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="alloc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreq')->textInput() ?>

    <?php
	$profiles = \backend\models\Profile::find()->where(['<>', 'name',  ''])->andWhere(['<>', 'name',  'Super'])->andWhere(['<>', 'name',  'Admin'])->andWhere(['<>', 'name',  'Director'])->all();

	if(Yii::$app->controller->action->id == 'update'){
		echo $form->field($model, 'idsolicitor')->dropDownList(
	        ArrayHelper::map($profiles, 'iduser', function ($profile) {
				return $profile->name . ' ' . $profile->lastname;
			}),
	        [
	            'options' => [$model->idsolicitor => ['Selected' => true],],
	        ]
	    );
	}else{    
		echo $form->field($model, 'idsolicitor')->dropDownList(
	        [], // Inicialmente vacío
	        [
	            'prompt' => 'Seleccione...',
	        ]
	    ); 
    }
    ?>

    <?= $form->field($model, 'amount')->textInput() ?>

	<?php
	if(Yii::$app->controller->action->id == 'update'){
		echo $form->field($model, 'idtoa')->dropDownList(
	        ArrayHelper::map(\backend\models\Toa::find()->all(), 'id', 'name'),
	        [
	            'prompt' => 'Seleccione...',
	        ]
	    );
	}else{
		echo $form->field($model, 'idtoa')->dropDownList(
	        ArrayHelper::map(\backend\models\Toa::find()->all(), 'id', 'name'),
	        [
	            'prompt' => 'Seleccione...',
	        ]
	    );
	}
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php #= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
