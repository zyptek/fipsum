<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pquote".
 *
 * @property int $id
 * @property int $idprovider
 * @property int $cost
 * @property string $created_at
 * @property int $idreq
 *
 * @property Provider $idprovider0
 * @property Req $idreq0
 * @property Squote[] $squotes
 */
class Pquote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pquote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idprovider', 'idreq'], 'required'],
            [['idprovider', 'cost', 'idreq'], 'integer'],
            [['created_at'], 'safe'],
            [['idprovider'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::class, 'targetAttribute' => ['idprovider' => 'id']],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idprovider' => 'Proveedor',
            'cost' => 'Costo',
            'created_at' => 'Fecha Solicitud',
            'idreq' => 'Requerimiento',
        ];
    }

    /**
     * Gets query for [[Idprovider0]].
     *
     * @return \yii\db\ActiveQuery|ProviderQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::class, ['id' => 'idprovider']);
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
     * Gets query for [[Squotes]].
     *
     * @return \yii\db\ActiveQuery|SquoteQuery
     */
    public function getSquotes()
    {
        return $this->hasMany(Squote::class, ['idpquote' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PquoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PquoteQuery(get_called_class());
    }
}
