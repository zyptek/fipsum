<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ocomp".
 *
 * @property int $id
 * @property int $noc
 * @property int $idtop
 * @property int $idvop
 * @property int $idreq
 * @property int $iduser
 * @property int $idprovider
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
class Ocomp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ocomp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['noc', 'idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'subtotal', 'neto', 'iva', 'total'], 'required'],
            [['noc', 'idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'subtotal', 'neto', 'iva', 'total'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'noc' => 'NOC',
            'idtop' => 'Idtop',
            'idvop' => 'Idvop',
            'idreq' => 'Requerimiento',
            'iduser' => 'Iduser',
            'idprovider' => 'Idprovider',
            'subtotal' => 'Subtotal',
            'neto' => 'Neto',
            'iva' => 'Iva',
            'total' => 'Total',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
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
     * Gets query for [[Idtop0]].
     *
     * @return \yii\db\ActiveQuery|TopQuery
     */
    public function getTop()
    {
        return $this->hasOne(Top::class, ['id' => 'idtop']);
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
     * Gets query for [[Idvop0]].
     *
     * @return \yii\db\ActiveQuery|VopQuery
     */
    public function getVop()
    {
        return $this->hasOne(Vop::class, ['id' => 'idvop']);
    }

    /**
     * {@inheritdoc}
     * @return OcompQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OcompQuery(get_called_class());
    }
}
