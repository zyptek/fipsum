<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Provider $model */
/** @var yii\widgets\ActiveForm $form */

?>
<div class="provider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <label>Regiones</label>
        <table class="table table-bordered">
            <?php
             // Array de regiones
            $total = count($regionList);
            $columns = 4; // Número de columnas por fila
            $selectedIds = array_column($selectedList, 'idregion');
            echo '<tr>';
            
            foreach ($regionList as $index => $region) {
                // Determina si la región debe estar marcada
                $isChecked = in_array($region['id'], $selectedIds);
                
                // Agrega una celda con el checkbox
                echo '<td>';
                echo Html::checkbox("regions[{$region['id']}]", $isChecked, [
                    'value' => $region['id'],
                    'class' => 'region-checkbox',
                ]) . ' ' . Html::encode($region['name']);
                echo '</td>';
                
                // Si alcanzamos el límite de columnas, cerramos la fila y abrimos otra
                if (($index + 1) % $columns === 0 && $index + 1 < $total) {
                    echo '</tr><tr>';
                }
            }
            
            // Cierra la fila si hay celdas incompletas
            $remainingCells = $columns - ($total % $columns);
            if ($remainingCells < $columns) {
                echo str_repeat('<td></td>', $remainingCells);
            }
            
            echo '</tr>';
            ?>
        </table>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
