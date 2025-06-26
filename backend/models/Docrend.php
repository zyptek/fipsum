<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "docrend".
 *
 * @property int $id
 * @property int $idreq
 * @property int $assigned_amount
 * @property int|null $expended_amount
 * @property int|null $difference
 * @property int|null $total
 * @property int $idsolicitor
 * @property int|null $qty_boletas
 * @property int|null $qty_peajes
 * @property int|null $qty_facturas
 * @property int|null $qty_nc
 * @property int $tot_boletas
 * @property int $tot_facturas
 * @property int $tot_nc
 * @property int $tot_peajes
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $detail_count
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
            [['idreq', 'assigned_amount', 'idsolicitor', 'tot_boletas', 'tot_facturas', 'tot_nc', 'tot_peajes'], 'required'],
            [['idreq', 'assigned_amount', 'expended_amount', 'difference', 'total', 'idsolicitor', 'qty_boletas', 'qty_peajes', 'qty_facturas', 'qty_nc', 'tot_boletas', 'tot_facturas', 'tot_nc', 'tot_peajes', 'detail_count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'idsolicitor' => 'Idsolicitor',
            'qty_boletas' => 'Qty Boletas',
            'qty_peajes' => 'Qty Peajes',
            'qty_facturas' => 'Qty Facturas',
            'qty_nc' => 'Qty Nc',
            'tot_boletas' => 'Tot Boletas',
            'tot_facturas' => 'Tot Facturas',
            'tot_nc' => 'Tot Nc',
            'tot_peajes' => 'Tot Peajes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'detail_count' => 'Detail Count',
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

    public function getSolicitorProfile()
    {
        return $this->hasOne(Profile::class, ['iduser' => 'idsolicitor']);
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
