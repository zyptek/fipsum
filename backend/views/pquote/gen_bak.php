<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->title = 'Generar Presupuesto';
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>ID Req	: <strong><?= Html::encode($idreq) ?></strong></p>

<div id="cart">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Costo</th>
                <th>Margen Contribución</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pquotes as $item): ?>
                <tr data-id="<?= $item->id ?>">
                    <td><?= Html::encode($item->id) ?></td>
                    <td><?= Html::encode($item->idprovider) ?></td>
                    <td><?= Html::encode($item->cost) ?></td>
                    <td>
                        <input type="text" class="form-control mc" name="mc[<?= $item->id ?>]" value="">
                    </td>
                    <td>
                        <button class="btn btn-danger remove-item">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $form = ActiveForm::begin(['action' => Url::to(['squote/generate-budget'])]); ?>
    <?= Html::hiddenInput('Squote[id]', $squote->id) ?>
    <?= Html::hiddenInput('Squote[items]', '', ['id' => 'squote-items']) ?>
    <button type="submit" class="btn btn-success">Generar Presupuesto</button>
<?php ActiveForm::end(); ?>

