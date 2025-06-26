<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "poc".
 *
 * @property int $id
 * @property int $idtop
 * @property int $idvop
 * @property int $idreq
 * @property int $iduser
 * @property int $idprovider
 * @property int $noc
 * @property string $descrip
 * @property int $subtotal
 * @property int $neto
 * @property int $iva
 * @property int $total
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Provider $idprovider0
 * @property Req $idreq0
 * @property Top $idtop0
 * @property User $iduser0
 * @property Vop $idvop0
 */
class Poc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'noc', 'descrip', 'subtotal', 'neto', 'iva', 'total'], 'required'],
            [['idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'noc', 'subtotal', 'neto', 'iva', 'total'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['descrip'], 'string', 'max' => 255],
            [['noc'], 'unique'],
            [['idprovider'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::class, 'targetAttribute' => ['idprovider' => 'id']],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
            [['idtop'], 'exist', 'skipOnError' => true, 'targetClass' => Top::class, 'targetAttribute' => ['idtop' => 'id']],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['iduser' => 'id']],
            [['idvop'], 'exist', 'skipOnError' => true, 'targetClass' => Vop::class, 'targetAttribute' => ['idvop' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idtop' => 'Tipo de Pago',
            'idvop' => 'Impuesto',
            'idreq' => 'Requerimiento',
            'iduser' => 'Usuario',
            'idprovider' => 'Proveedor',
            'noc' => 'NOC',
            'descrip' => 'Descripción',
            'subtotal' => 'Subtotal',
            'neto' => 'Neto',
            'iva' => 'Impuesto',
            'total' => 'Total',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Idprovider0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIdprovider0()
    {
        return $this->hasOne(Provider::class, ['id' => 'idprovider']);
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
     * Gets query for [[Idtop0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIdtop0()
    {
        return $this->hasOne(Top::class, ['id' => 'idtop']);
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
     * Gets query for [[Idvop0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIdvop0()
    {
        return $this->hasOne(Vop::class, ['id' => 'idvop']);
    }

    /**
     * {@inheritdoc}
     * @return PocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PocQuery(get_called_class());
    }
}
