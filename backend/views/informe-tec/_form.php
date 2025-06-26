<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use vova07\imperavi\Widget;
use kartik\editors\Summernote;

/** @var yii\web\View $this */
/** @var backend\models\Inftec $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
#redactor-droparea, redactor-modal-image-droparea, redactor-modal-tabber{
	display:none;
}
</style>
<div class="inftec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreq')->textInput(['readonly' => true,]) ?>

    <?php /*
= $form->field($model, 'detalle')->widget(TinyMce::class, [
	    'options' => ['rows' => 6],
	    'language' => 'es',
	    'clientOptions' => [
		    'license_key' => 'gpl',
	        'plugins' => 'fontsize advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code wordcount',
	        'toolbar' => 'fontsize | undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | visualblocks insertdatetime table code',
	        'menubar' => false,
	        'formats' => [
	            'bold' => ['inline' => 'strong'],
	            'italic' => ['inline' => 'em']
			],
			'forced_root_block' => 'p',
	        'force_p_newlines' => true,
	        'cleanup' => true,
	        'verify_html' => true,
	        'paste_as_text' => true,
	        'paste_remove_styles' => true,
	        'paste_remove_spans' => true,
	        'paste_strip_class_attributes' => 'all',
	        'valid_elements' => '*[*]', // Puedes restringir aún más si lo deseas
	        'invalid_styles' => 'color font-family font-size', // elimina estilos conflictivos
	        'content_style' => 'body { font-family:Arial; font-size:14px }',
	    ]
	]);
 ?>

	<?= $form->field($model, 'detalle')->widget(Widget::className(), [
	    'settings' => [
		    'selector' => '#textarea-main',
	        'lang' => 'es',
	        'minHeight' => 200,
	        'plugins' => [
	            'fullscreen','imagemanager',
	        ],
	        'buttons' => [ 'bold', 'italic', 'underline','deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'image', 'file', 'link', 'alignment', 'horizontalrule', 'html', 'formatting'],
	        'imageUpload' => Url::to(['web/uploads']),
	        'imageManagerJson' => Url::to(['/informe-tec/images-get']),
	    ],
	]);
/**/

	echo $form->field($model, 'detalle')->widget(Summernote::class, [
		'options' => ['placeholder' => ''],
		'container' => [
			'class' => 'kv-editor-container',
		],
		'pluginOptions' => [
	        'toolbar' => [
	            ['style', ['bold', 'italic', 'underline', 'clear']],
	            ['font', ['strikethrough', 'superscript', 'subscript']],
	            ['fontsize', ['fontsize']],
#	            ['color', ['color']],
	            ['para', ['ul', 'ol', 'paragraph']],
	            ['insert', ['link', 'picture']],
	            ['view', ['fullscreen', 'codeview']],
	        ],
		],
	]);


?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<button id="generate-docx-btn">
  Exportar
</button>
</div>
<?php
$this->registerJsFile('@web/js/pizzip.min.js', [
    'position' => \yii\web\View::POS_END, // Carga el script al final
]);
$this->registerJsFile('@web/js/docxtemplater.js', [
    'position' => \yii\web\View::POS_END, // Carga el script al final
]);
$this->registerJsFile('@web/js/html-module.min.js', [
    'position' => \yii\web\View::POS_END, // Carga el script al final
]);

$this->registerJs(<<<JS

window.addEventListener('load', function() {
const btn = document.getElementById("generate-docx-btn");
btn.addEventListener("click", async function () {
    const htmlContent = document.querySelector(".note-editable").innerHTML;

    const content = await fetch("https://sc.fipsum.cl/js/template-it2.docx").then(res => res.arrayBuffer());

    const zip = new PizZip(content);

    const htmlModule = new HtmlModule();
    const doc = new window.docxtemplater.Docxtemplater(zip, {
      modules: [htmlModule],
    });

    doc.setData({ content: htmlContent });

    try {
      doc.render();
    } catch (e) {
      console.log("Error renderizando:", e);
      throw e;
    }

    const out = doc.getZip().generate({ type: "blob" });

    saveAs(out, "documento_generado.docx");
  });
});

JS
);
?>
<script>
</script>