<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "inftec".
 *
 * @property int $id
 * @property int $idreq
 * @property string $detalle
 * @property string $created_at
 *
 * @property Req $idreq0
 * @property InftecImage[] $inftecImages
 * @property Inftecdetail[] $inftecdetails
 */
class Inftec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inftec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreq', 'detalle'], 'required'],
            [['idreq'], 'integer'],
            [['detalle'], 'string'],
            [['created_at'], 'safe'],
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
            'idreq' => 'Requerimiento',
            'detalle' => 'Detalle',
            'created_at' => 'Creado',
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
     * Gets query for [[InftecImages]].
     *
     * @return \yii\db\ActiveQuery|InftecImageQuery
     */
    public function getImages()
    {
        return $this->hasMany(InftecImage::class, ['idit' => 'id']);
    }

    /**
     * Gets query for [[Inftecdetails]].
     *
     * @return \yii\db\ActiveQuery|InftecdetailQuery
     */
    public function getDetails()
    {
        return $this->hasMany(Inftecdetail::class, ['idinftec' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InftecQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InftecQuery(get_called_class());
    }
}
