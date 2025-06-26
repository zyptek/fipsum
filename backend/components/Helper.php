<?php
	
namespace backend\components;

use Yii;
use yii\base\Component;

class Helper extends Component
{
	public static function loadModules()
	{
		$session = Yii::$app->session;
        $userModules = \backend\models\Module::find()
            ->select(['name', 'descrip']) // Solo selecciona las columnas necesarias.
            ->innerJoin('user_module', 'module.id = user_module.idmodule') // Une con la tabla intermedia.
            ->where(['user_module.iduser' => Yii::$app->user->id]) // Filtra por el ID del usuario.
            ->asArray() // Retorna los resultados como un array.
            ->all();
	    $session->set('userModules',$userModules);
	}
}

