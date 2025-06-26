<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "squote_detail".
 *
 * @property int $id
 * @property int $idsquote
 * @property int $idreq
 * @property string $item
 * @property string $descrip
 * @property string $unit
 * @property int $cost
 * @property int $quant
 * @property int $total
 * @property string $created_at
 *
 * @property Req $idreq0
 * @property Squote $idsquote0
 */
class SquoteDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'squote_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsquote', 'idreq', 'item', 'descrip', 'unit', 'cost', 'quant', 'total'], 'required'],
            [['idsquote', 'idreq', 'cost', 'quant', 'total'], 'integer'],
            [['created_at'], 'safe'],
            [['item'], 'string', 'max' => 10],
            [['descrip'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 5],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
            [['idsquote'], 'exist', 'skipOnError' => true, 'targetClass' => Squote::class, 'targetAttribute' => ['idsquote' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idsquote' => 'Idsquote',
            'idreq' => 'Idreq',
            'item' => 'Item',
            'descrip' => 'Descrip',
            'unit' => 'Unit',
            'cost' => 'Cost',
            'quant' => 'Quant',
            'total' => 'Total',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Idreq0]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getIdreq0()
    {
        return $this->hasOne(Req::class, ['id' => 'idreq']);
    }

    /**
     * Gets query for [[Idsquote0]].
     *
     * @return \yii\db\ActiveQuery|SquoteQuery
     */
    public function getIdsquote0()
    {
        return $this->hasOne(Squote::class, ['id' => 'idsquote']);
    }

    /**
     * {@inheritdoc}
     * @return SquoteDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SquoteDetailQuery(get_called_class());
    }
}
