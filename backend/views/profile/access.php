<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $user common\models\User */
/** @var $modules array */
/** @var $userModules array */

$this->title = 'Administrar Permisos';
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permissions-index">
    <h1><?= Html::encode($this->title . ": " . $profile->role->name) ?></h1>

    <p>Administrar permisos para el usuario: <strong><?= Html::encode($profile->name . " " . $profile->lastname) ?></strong></p>

    <?php $form = ActiveForm::begin(['action' => Url::to(['profile/access', 'id' => $user->id])]); ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
    <?php
    $moduleActions = json_decode($module['actions'], true);
    $permissions = isset($userModules[$module['id']]['permissions']) ? json_decode($userModules[$module['id']]['permissions'], true) : [];
    ?>
    <tr>
        <td><?= Html::encode($module['descrip']) ?></td>
        <td>
            <?php foreach ($moduleActions as $action => $label): ?>
                <label style="margin-right:10px;">
            	<input type="hidden" name="<?php echo "permissions[{$module['id']}][ignore]"; ?>" value="1">
                    <?= Html::checkbox("permissions[{$module['id']}][{$action}]", !empty($permissions[$action]), [
                        'label' => $label,
                    ]) ?>
                </label>
            <?php endforeach; ?>
        </td>
    </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Guardar Permisos', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
