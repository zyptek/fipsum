<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "user_module".
 *
 * @property int $create
 * @property int $read
 * @property int $update
 * @property int $delete
 * @property int $iduser
 * @property int $idmodule
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Module $idmodule0
 * @property User $iduser0
 */
class UserModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create', 'read', 'update', 'delete', 'iduser', 'idmodule'], 'integer'],
            [['iduser', 'idmodule'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['iduser', 'idmodule'], 'unique', 'targetAttribute' => ['iduser', 'idmodule']],
            [['idmodule'], 'exist', 'skipOnError' => true, 'targetClass' => Module::class, 'targetAttribute' => ['idmodule' => 'id']],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['iduser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'create' => 'Crear',
            'read' => 'Leer',
            'update' => 'Actualizar',
            'delete' => 'eliminar',
            'iduser' => 'Iduser',
            'idmodule' => 'Idmodule',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Idmodule0]].
     *
     * @return \yii\db\ActiveQuery|ModuleQuery
     */
    public function getIdmodule0()
    {
        return $this->hasOne(Module::class, ['id' => 'idmodule']);
    }

    /**
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(User::class, ['id' => 'iduser']);
    }

    /**
     * {@inheritdoc}
     * @return UserModuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserModuleQuery(get_called_class());
    }
    public static function updateUserPermissions($userId, $permissions)
    {
        // Eliminar permisos existentes del usuario
        self::deleteAll(['iduser' => $userId]);

        // Insertar nuevos permisos
        foreach ($permissions as $moduleId => $permission) {
            $model = new self();
            $model->iduser = $userId;
            $model->idmodule = $moduleId;
            $model->create = isset($permission['create']) ? 1 : 0;
            $model->read = isset($permission['read']) ? 1 : 0;
            $model->update = isset($permission['update']) ? 1 : 0;
            $model->delete = isset($permission['delete']) ? 1 : 0;
            $model->save();
        }
    }
}
