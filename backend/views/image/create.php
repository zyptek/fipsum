<?php
#use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var backend\models\Image $model
 * @var int $relatedId
 * @var string $relatedModel
 */

$imageCategories = ArrayHelper::map(\backend\models\Imagecat::find()->all(), 'id', 'name');
?>

<div class="image-create">
    <h3>Subir Imagen</h3>

    <!-- Contenedor del Loader -->
    <div id="loader" style="display: none; text-align: center;">
        <img src="/images/loader.gif" width="50" alt="Cargando...">
    </div>

    <!-- Formulario -->
    <?php $form = ActiveForm::begin([
        'id' => 'image-upload-form',
        'options' => ['enctype' => 'multipart/form-data'],  // Asegura que se puedan enviar archivos
        'action' => ['image/create'],  // Verifica que esta sea la acción correcta
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'path')->fileInput()->label('Archivo: ') ?>
    <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>
    <?php
	if(isset($idcat)){
		echo Html::hiddenInput('idcat', $idcat);
	}else{ 
	    echo $form->field($model, 'idcat')->dropDownList($imageCategories, ['prompt' => 'Seleccione una categoría'])->label('Categoría');
	}
	?>
    <?= Html::hiddenInput('relatedId', $relatedId) ?>
    <?= Html::hiddenInput('relatedModel', $relatedModel) ?>

    <div class="form-group">
        <?= Html::button('Subir Imagen', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php # = Yii::$app->controller->id?>
<?php $this->registerJsFile('@web/js/upload_file.js', [
    'depends' => ['yii\web\JqueryAsset'], // Asegura que jQuery se cargue primero
    'position' => \yii\web\View::POS_END, // Carga el script al final
]); ?>

