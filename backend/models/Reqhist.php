<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "reqhist".
 *
 * @property int $id
 * @property int $idreq
 * @property int $idhisttype
 * @property int $iduser
 * @property string $detail
 * @property string $created_at
 *
 * @property Histtype $idhisttype0
 * @property Req $idreq0
 * @property User $iduser0
 */
class Reqhist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reqhist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreq', 'idhisttype', 'iduser', 'detail'], 'required'],
            [['idreq', 'idhisttype', 'iduser'], 'integer'],
            [['created_at'], 'safe'],
            [['detail'], 'string', 'max' => 200],
            [['idhisttype'], 'exist', 'skipOnError' => true, 'targetClass' => Histtype::class, 'targetAttribute' => ['idhisttype' => 'id']],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
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
            'idreq' => 'Idreq',
            'idhisttype' => 'Estado',
            'iduser' => 'Iduser',
            'detail' => 'Detalle',
            'created_at' => 'Fecha',
        ];
    }

    /**
     * Gets query for [[Idhisttype0]].
     *
     * @return \yii\db\ActiveQuery|HisttypeQuery
     */
    public function getHisttype()
    {
        return $this->hasOne(Histtype::class, ['id' => 'idhisttype']);
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
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getIduser()
    {
        return $this->hasOne(User::class, ['id' => 'iduser']);
    }

    /**
     * {@inheritdoc}
     * @return ReqhistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReqhistQuery(get_called_class());
    }
}
