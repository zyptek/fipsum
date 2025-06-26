<?php
	
namespace backend\components;

use Yii;
use yii\base\Component;
use backend\models\Profile;
use backend\models\Module;
use yii\db\Expression;


class Helper extends Component
{
	public static function loadModules()
	{
		$session = Yii::$app->session;
		$userId = Yii::$app->user->id;
		$profile = Profile::findOne(['iduser' => $userId]);
		Yii::info("nutz: ". print_r($profile->idrole, true), __METHOD__);
		if($profile->idrole > 12){
			Yii::info("nutz: Mayor que 12", __METHOD__);
			$userModules = Module::find()
			->select(['name', 'descrip']) // Solo selecciona todos.
            ->asArray() // Retorna los resultados como un array.
            ->all();
		}else{
			Yii::info("nutz: Menor que 12", __METHOD__);
	        $userModules = Module::find()
	            ->select(['name', 'descrip']) // Solo selecciona las columnas necesarias.
	            ->innerJoin('user_module', 'module.id = user_module.idmodule') // Une con la tabla intermedia.
	            ->where(['user_module.iduser' => Yii::$app->user->id]) // Filtra por el ID del usuario.
	            ->andWhere(new Expression("
        JSON_EXTRACT(user_module.permissions, '$.index') = 1 OR
        JSON_EXTRACT(user_module.permissions, '$.create') = 1 OR
        JSON_EXTRACT(user_module.permissions, '$.view') = 1 OR
        JSON_EXTRACT(user_module.permissions, '$.update') = 1 OR
        JSON_EXTRACT(user_module.permissions, '$.delete') = 1
    "))
	            ->asArray() // Retorna los resultados como un array.
	            ->all();
		}
	    $session->set('userModules',$userModules);
	}
}

