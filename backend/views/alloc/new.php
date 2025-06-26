<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Alloc $model */

$this->title = 'Ingresar Asignación';
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="alloc-create">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="alloc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreq')->textInput(['readonly' => true]) ?>
    
    <?php $profiles = \backend\models\Profile::find()->where(['<>', 'name',  ''])->andWhere(['<>', 'name',  'Super'])->andWhere(['<>', 'name',  'Admin'])->andWhere(['<>', 'name',  'Director'])->all();
	    
	    echo $form->field($model, 'idsolicitor')->dropDownList(
		    ArrayHelper::map($profiles, 'iduser', function ($profile) {
				return $profile->name . ' ' . $profile->lastname;
			}),
	        [
	            'prompt' => 'Seleccione...',
	            'id' => 'select-user',
	        ]
        );
    ?>

	<?= $form->field($model, 'idtoa')->dropDownList(
		    ArrayHelper::map(\backend\models\Toa::find()->all(), 'id', 'name'),
	        [
	            'prompt' => 'Seleccione...',
	            'id' => 'select-user',
	        ]
        );
    ?>
        
    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
