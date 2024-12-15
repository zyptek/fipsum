<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var backend\models\Req $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="req-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'idcompany')->dropDownList(
        ArrayHelper::map(\backend\models\Company::find()->all(), 'id', 'alias'),
        [
            'prompt' => 'Seleccione...',
            'id' => 'select-company', // ID para manejar con JS
        ]
    ) ?>
    
    <?php
	if(Yii::$app->controller->action->id == 'update'){
		echo $form->field($model, 'idbranch')->dropDownList(
	        ArrayHelper::map(\backend\models\Branch::find()->all(), 'id', 'name'),
	        [
	            'options' => [$model->idbranch => ['Selected' => true],],
	        ]
	    );
	}else{    
		echo $form->field($model, 'idbranch')->dropDownList(
        [], // Inicialmente vacío
        [
            'prompt' => 'Seleccione Cliente...',
            'id' => 'select-branch', // ID para manejar con JS
        ]
    )->label('Sucursal'); 
    }?>
    
    <?php # $form->field($model, 'idbranch')->textInput()->label("Sucursal") ?>
    
    <?= $form->field($model, 'idsolicitor')->dropDownList(
        ArrayHelper::map(\backend\models\Solicitor::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Seleccione...',
            'id' => 'select-solicitor', // ID para manejar con JS
        ]
    ) ?>
    <?php # = $form->field($model, 'idsolicitor')->textInput() ?>
    
    <?php # = $form->field($model, 'idkam')->textInput() ?>

    <?= $form->field($model, 'idalt')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'idtos')->dropDownList(
    ArrayHelper::map(
        \backend\models\Tos::find()->all(),
        'id',
        function ($model) {
            return ucwords(strtolower($model->name));
        }
    ),
    [
        'prompt' => 'Seleccione...',
    ]
) ?>
    
    <?= $form->field($model, 'idactivity')->dropDownList(
		    ArrayHelper::map(
		        \backend\models\Activity::find()->all(),
		        'id',
		        function ($model) {
		            return ucwords(strtolower($model->name));
		        }
		    ),
		    [
		        'prompt' => 'Seleccione...',
		    ]
	    );?>
    
    <?= $form->field($model, 'estdays')->textInput() ?>
    
    <?= $form->field($model, 'inidetail')->textarea(['rows' => 6]) ?>
    
    <?php #= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
   
	<?php
    if(Yii::$app->controller->action->id == 'update'){
        echo $form->field($model, 'idstatus')->dropDownList(
        ArrayHelper::map(\backend\models\Status::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Seleccione...',
        ]
        );
    }else{
        echo $form->field($model, 'idstatus')->dropDownList(
            ArrayHelper::map(\backend\models\Status::find()->where(['>', 'id', 11])->all(), 'id', 'name'),
            [
                'prompt' => 'Seleccione...',
            ]
            );
    } ?>


    <?php # = $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJsFile('@web/js/cliente-sucursal.js', [
    'depends' => ['yii\web\JqueryAsset'], // Asegura que jQuery se cargue primero
    'position' => \yii\web\View::POS_END, // Carga el script al final
]);

$branchesUrl = \yii\helpers\Url::to(['get-branches']);
$solicitorUrl = \yii\helpers\Url::to(['get-solicitor']);
$this->registerJs("
    var branchesUrl = '{$branchesUrl}'; // Genera la URL correctamente
    var solicitorUrl = '{$solicitorUrl}';
", \yii\web\View::POS_END);


?>
