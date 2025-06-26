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
 * @property string|null $alias
 * @property string|null $telefono
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
            [['alias'], 'string', 'max' => 20],
            [['telefono'], 'string', 'max' => 11],
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
            'alias' => 'Alias',
            'telefono' => 'Teléfono',
            'iduser' => 'Iduser',
            'idrole' => 'Rol',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
            'roleName' => 'Rol',
            'eMail' => 'E-mail',
        ];
    }

    /**
     * Gets query for [[Idrole0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'idrole']);
    }

    /**
     * Gets query for [[Iduser0]].
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
