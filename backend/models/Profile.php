<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $lastname
 * @property int $iduser
 * @property int $idrole
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Role $idrole0
 * @property User $iduser0
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser', 'idrole'], 'required'],
            [['iduser', 'idrole'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'lastname'], 'string', 'max' => 45],
            [['idrole'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['idrole' => 'id']],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['iduser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'iduser' => 'Iduser',
            'idrole' => 'Rol',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Idrole0]].
     *
     * @return \yii\db\ActiveQuery|RoleQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'idrole']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'iduser']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
