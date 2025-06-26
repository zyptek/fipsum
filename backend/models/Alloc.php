<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "alloc".
 *
 * @property int $id
 * @property int $idreq
 * @property int $idsolicitor
 * @property int $iduser
 * @property int $amount
 * @property int $idtoa
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $idstatus
 * @property int $paid
 *
 * @property Req $idreq0
 * @property User $idsolicitor0
 * @property Allocstatus $idstatus0
 * @property Toa $idtoa0
 * @property User $iduser0
 */
class Alloc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alloc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreq', 'idsolicitor', 'iduser', 'amount', 'idtoa', 'description'], 'required'],
            [['idreq', 'idsolicitor', 'iduser', 'amount', 'idtoa', 'idstatus', 'paid'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
            [['idsolicitor'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['idsolicitor' => 'id']],
            [['idstatus'], 'exist', 'skipOnError' => true, 'targetClass' => Allocstatus::class, 'targetAttribute' => ['idstatus' => 'id']],
            [['idtoa'], 'exist', 'skipOnError' => true, 'targetClass' => Toa::class, 'targetAttribute' => ['idtoa' => 'id']],
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
            'idreq' => 'Requerimiento',
            'idsolicitor' => 'Solicitante',
            'iduser' => '',
            'amount' => 'Monto',
            'idtoa' => 'Tipo',
            'description' => 'Descripción',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
            'idstatus' => 'Estado',
            'paid' => 'Pagado',
        ];
    }

    /**
     * Gets query for [[Idreq0]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReq()
    {
        return $this->hasOne(Req::class, ['id' => 'idreq']);
    }

    /**
     * Gets query for [[Idsolicitor0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getSolicitor()
    {
        return $this->hasOne(User::class, ['id' => 'idsolicitor']);
    }

    /**
     * Gets query for [[Idstatus0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Allocstatus::class, ['id' => 'idstatus']);
    }

    /**
     * Gets query for [[Idtoa0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getToa()
    {
        return $this->hasOne(Toa::class, ['id' => 'idtoa']);
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
	
	public function getProfile()
    {
        return $this->hasOne(Profile::class, ['iduser' => 'iduser']);
    }
    	public function getSolicitorProfile()
    {
        return $this->hasOne(Profile::class, ['iduser' => 'idsolicitor']);
    }
    /**
     * {@inheritdoc}
     * @return AllocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AllocQuery(get_called_class());
    }
}
