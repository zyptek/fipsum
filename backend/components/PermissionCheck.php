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
        $moduleId = Module::find()->where(['name' => $moduleName])->one();

        Yii::info("Checking permission for user $userId on module $moduleName and action $action", __METHOD__);

        // Si el usuario no está autenticado, denegar acceso
        if (!$userId) {
            Yii::info("User not authenticated", __METHOD__);
            return false;
        }

        if ($this->hasFullAccess($userId)) {
            Yii::info("User has full access due to role", __METHOD__);
            return true;
        }
        // Mapear las acciones a los permisos
        $actionToPermission = [
            'create' => 'create',
            'quote' => 'read',
            'view'   => 'read',
            'index'  => 'read',
            'update' => 'update',
            'delete' => 'delete',
        ];

        // Validar si la acción está soportada
        if (!isset($actionToPermission[$action])) {
            return false; // Acción no reconocida
        }

        
        // Obtener los permisos del usuario para el módulo
        $permissions = UserModule::find()
            ->where(['iduser' => $userId, 'idmodule' => $moduleId])
            ->asArray()
            ->one();

        $hasPermission = isset($permissions[$actionToPermission[$action]]) && $permissions[$actionToPermission[$action]] == 1;

        if (!$hasPermission) {
            // Redirección con mensaje si no tiene permiso
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
        $permissions = UserModule::find()
            ->where(['iduser' => $userId, 'idmodule' => strtolower($moduleName)])
            ->asArray()
            ->one();

        if (!$permissions) {
            return false;
        }

        // Verificar si al menos un permiso está habilitado
        return $permissions['create'] == 1 ||
               $permissions['read'] == 1 ||
               $permissions['update'] == 1 ||
               $permissions['delete'] == 1;
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
