<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use backend\models\UserModule;
use backend\models\Profile;
use backend\models\Module;

class PermissionCheck extends Component
{
    /**
     * Verifica si el usuario actual tiene permiso para realizar una acción en un módulo.
     *
     * @param string $moduleName Nombre del módulo (coincide con el controlador).
     * @param string $action Nombre de la acción (create, read, update, delete).
     * @return bool True si el permiso está habilitado, False en caso contrario.
     */
	public function checkPermission($moduleName, $action)
	{
	    $userId = Yii::$app->user->id;
	    if (!$userId) {
	        return false;
	    }
	
	    if ($this->hasFullAccess($userId)) {
	        return true;
	    }
	
	    $module = Module::find()->where(['name' => $moduleName])->one();
	    if (!$module) {
	        return false;
	    }
	
	    $userModule = UserModule::find()
	        ->where(['iduser' => $userId, 'idmodule' => $module->id])
	        ->one();
	
	    if (!$userModule) {
	        return false;
	    }
	
	    $permissions = $userModule->getPermissions();
		Yii::info('permisos: ' . print_r($action, true), __METHOD__);
	    $hasPermission = isset($permissions[$action]) && $permissions[$action] == 1;
		
	    if (!$hasPermission) {
	        $this->handleForbiddenAccess($moduleName, $userId);
	    }
	
	    return $hasPermission;
	}


    /**
     * Verifica si el usuario tiene acceso total basado en su rol.
     *
     * @param int $userId ID del usuario.
     * @return bool True si tiene acceso total, False en caso contrario.
     */
    private function hasFullAccess($userId)
    {
        $profile = Profile::find()->where(['iduser' => $userId])->one();

        return $profile && $profile->idrole > 11;
    }

    /**
     * Verifica si el usuario tiene al menos un permiso habilitado (create, read, update, delete) para un módulo.
     *
     * @param string $moduleName Nombre del módulo.
     * @param int $userId ID del usuario.
     * @return bool True si tiene al menos un permiso habilitado, False en caso contrario.
     */
    private function hasAnyPermission($moduleName, $userId)
	{
	    $module = Module::find()->where(['name' => $moduleName])->one();
	    if (!$module) {
	        return false;
	    }
	
	    $userModule = UserModule::find()
	        ->where(['iduser' => $userId, 'idmodule' => $module->id])
	        ->one();
	
	    if (!$userModule) {
	        return false;
	    }
	
	    $permissions = $userModule->getPermissions();
	
	    return !empty(array_filter($permissions)); // Algún permiso activo
	}
    /**
     * Maneja accesos prohibidos redirigiendo al usuario a actionIndex si tiene acceso
     * a alguna acción o lanzando un ForbiddenHttpException.
     */
    private function handleForbiddenAccess($moduleName, $userId)
    {
        if ($this->hasAnyPermission($moduleName, $userId)) {
            Yii::$app->session->setFlash('error', 'No tiene acceso a esta sección.');
            $controller = Yii::$app->controller->id;
            Yii::$app->controller->redirect([$controller . '/index'])->send();
            Yii::$app->end();
        }else{
            Yii::$app->session->setFlash('error', 'No tiene acceso a esta sección.');
            Yii::$app->getResponse()->redirect(['site/index'])->send();
            Yii::$app->end();
        }

        throw new ForbiddenHttpException('No tiene permitido ejecutar esta acción.');
    }
}


