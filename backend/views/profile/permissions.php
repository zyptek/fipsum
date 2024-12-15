<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $user common\models\User */
/** @var $modules array */
/** @var $userModules array */

$this->title = 'Administrar Permisos';
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permissions-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Administrar permisos para el usuario: <strong><?= Html::encode($user->username) ?></strong></p>

    <?php $form = ActiveForm::begin(['action' => Url::to(['profile/permissions', 'id' => $user->id])]); ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Crear</th>
                <th>Leer</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
                <?php
                $permissions = $userModules[$module['id']] ?? ['create' => 0, 'read' => 0, 'update' => 0, 'delete' => 0];
                ?>
                <tr>
                    <td><?= Html::encode($module['descrip']) ?></td>
                    <td>
                        <?= Html::checkbox("permissions[{$module['id']}][create]", $permissions['create'], [
                            'label' => '',
                        ]) ?>
                    </td>
                    <td>
                        <?= Html::checkbox("permissions[{$module['id']}][read]", $permissions['read'], [
                            'label' => '',
                        ]) ?>
                    </td>
                    <td>
                        <?= Html::checkbox("permissions[{$module['id']}][update]", $permissions['update'], [
                            'label' => '',
                        ]) ?>
                    </td>
                    <td>
                        <?= Html::checkbox("permissions[{$module['id']}][delete]", $permissions['delete'], [
                            'label' => '',
                        ]) ?>
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
