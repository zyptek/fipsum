<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "docrend".
 *
 * @property int $id
 * @property int $idreq
 * @property int $assigned_amount
 * @property int $expended_amount
 * @property int $difference
 * @property int $total
 * @property int $idsolicitor
 * @property string $presented_by
 * @property int $count_boletas
 * @property int $count_peajes
 * @property int $count_facturas
 * @property int $count_nc
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Drdetail[] $drdetails
 * @property Req $idreq0
 * @property User $idsolicitor0
 */
class Docrend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docrend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreq', 'assigned_amount', 'expended_amount', 'difference', 'total', 'idsolicitor', 'presented_by', 'count_boletas', 'count_peajes', 'count_facturas', 'count_nc'], 'required'],
            [['idreq', 'assigned_amount', 'expended_amount', 'difference', 'total', 'idsolicitor', 'count_boletas', 'count_peajes', 'count_facturas', 'count_nc'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['presented_by'], 'string', 'max' => 100],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
            [['idsolicitor'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['idsolicitor' => 'id']],
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
            'assigned_amount' => 'Monto Asignado',
            'expended_amount' => 'Monto Rendido',
            'difference' => 'Diferencia',
            'total' => 'Total',
            'idsolicitor' => 'Solicitante',
            'presented_by' => 'Presented By',
            'count_boletas' => 'Count Boletas',
            'count_peajes' => 'Count Peajes',
            'count_facturas' => 'Count Facturas',
            'count_nc' => 'Count Nc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Drdetails]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(Drdetail::class, ['iddocrend' => 'id']);
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
     * {@inheritdoc}
     * @return DocrendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocrendQuery(get_called_class());
    }
}
