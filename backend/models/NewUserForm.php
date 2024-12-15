<?php
	
namespace backend\models;

use yii\base\Model;
use common\models\User;
use backend\models\Role;

class NewUserForm extends Model
{
    public $email;
	public $idrole;
	
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Este correo ya está registrado.'],
            [['idrole'], 'required'], 
            [['idrole'], 'exist', 'targetClass' => Role::class, 'targetAttribute' => 'id', 'message' => 'El rol seleccionado no existe.'],
        ];
    }
}
