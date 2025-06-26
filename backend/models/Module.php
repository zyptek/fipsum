<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "module".
 *
 * @property int $id
 * @property string $name
 * @property string $descrip
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $idusers
 * @property UserModule[] $userModules
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'descrip'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'descrip'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Modelo',
            'descrip' => 'Identificador',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Idusers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'iduser'])->viaTable('user_module', ['idmodule' => 'id']);
    }

    /**
     * Gets query for [[UserModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserModules()
    {
        return $this->hasMany(UserModule::class, ['idmodule' => 'id']);
    }
}
