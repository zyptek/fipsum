<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use dosamigos\tinymce\TinyMce;
use backend\components\ImageGalleryWidget;

/** @var yii\web\View $this */
/** @var backend\models\Inftec $model */

$this->title = "Nuevo Informe";
$this->params['breadcrumbs'][] = ['label' => 'Informe Técnico', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inftec-new">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # = Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* = Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) /**/?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idreq',
        ],
    ]) ?>

</div>
<div class="inftec-form">
	<div class="form-group">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= (isset($idreq)) ? '<input type="hidden" name="Inftec[idreq]" value="' . $idreq .'" />' : "" ?>
    
	<?= $form->field($model, 'detalle')->widget(TinyMce::class, [
	    'options' => ['rows' => 6],
	    'language' => 'es',
	    'clientOptions' => [
		    'license_key' => 'gpl',
	        'plugins' => 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code wordcount',
	        'toolbar' => 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | visualblocks insertdatetime table code',
	        'menubar' => false,
	        'formats' => [
	            'bold' => ['inline' => 'strong'],
	            'italic' => ['inline' => 'em']
			],
			'forced_root_block' => 'p',
	        'force_p_newlines' => true,
	        'cleanup' => true,
	        'verify_html' => true
	    ]
	]); ?>



    <h2>Imágenes</h2>
<pre>
	<?php
		if(!isset($bla)) $bla = "";
		print_r($bla)
	
?></pre>
<?php
	echo ImageGalleryWidget::widget([
    'relatedId' => $model->idreq, // ID del modelo actual
    'relatedModel' => 'req', // Nombre de la tabla
    'type' => 'all',
    'check' => $images,
]);
?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
	$this->registerJs(<<<JS
$(window).on("load", function() {
	setTimeout(function() {
$(".tox-statusbar__branding a").remove(); // Elimina todos los enlaces dentro del span
}),500});
JS
);
?>