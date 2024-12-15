<?php
	
namespace backend\models;

use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['newPassword', 'confirmPassword'], 'required'],
            [['newPassword'], 'string', 'min' => 6],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Las contraseñas deben coincidir.'],
        ];
    }
}
