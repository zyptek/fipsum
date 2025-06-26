<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "squote".
 *
 * @property int $id
 * @property int|null $mc
 * @property float|null $cmp
 * @property int $subtotal
 * @property int $gg
 * @property int $neto
 * @property int $iva
 * @property int|null $total
 * @property string $created_at
 * @property int|null $accepted
 * @property int|null $author_accepted
 * @property string|null $date_accepted
 * @property int|null $approved_f
 * @property int|null $approved_c
 * @property int $idreq
 * @property int|null $idpquote
 *
 * @property Pquote $idpquote0
 * @property Req $idreq0
 * @property SquoteDetail[] $squoteDetails
 */
class Squote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'squote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mc', 'subtotal', 'gg', 'neto', 'iva', 'total', 'accepted', 'author_accepted', 'approved_f', 'approved_c', 'idreq', 'idpquote'], 'integer'],
            [['cmp'], 'number'],
            [['subtotal', 'gg', 'neto', 'iva', 'idreq'], 'required'],
            [['created_at', 'date_accepted'], 'safe'],
            [['idpquote'], 'exist', 'skipOnError' => true, 'targetClass' => Pquote::class, 'targetAttribute' => ['idpquote' => 'id']],
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
            'mc' => 'Mc',
            'cmp' => 'Cmp',
            'subtotal' => 'Subtotal',
            'gg' => 'Gg',
            'neto' => 'Neto',
            'iva' => 'Iva',
            'total' => 'Total',
            'created_at' => 'Creado',
            'accepted' => 'Accepted',
            'author_accepted' => 'Author Accepted',
            'date_accepted' => 'Date Accepted',
            'approved_f' => 'Approved F',
            'approved_c' => 'Approved C',
            'idreq' => 'Requerimiento',
            'idpquote' => 'Idpquote',
        ];
    }

    /**
     * Gets query for [[Idpquote0]].
     *
     * @return \yii\db\ActiveQuery|PquoteQuery
     */
    public function getPquote()
    {
        return $this->hasOne(Pquote::class, ['id' => 'idpquote']);
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
     * Gets query for [[SquoteDetails]].
     *
     * @return \yii\db\ActiveQuery|SquoteDetailQuery
     */
    public function getSquoteDetails()
    {
        return $this->hasMany(SquoteDetail::class, ['idsquote' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SquoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SquoteQuery(get_called_class());
    }
    
    /**
     * {@inheritdoc}
     * @return Cliente the active query used by this AR class.
     */
    public function getCliente()
	{
	    return $this->hasOne(Company::class, ['id' => 'idcompany'])
			->via('req');
	}
	public function getSolicitor()
	{
	    return $this->hasOne(Solicitor::class, ['id' => 'idsolicitor'])
			->via('req');
	}
	public function getBranch()
	{
	    return $this->hasOne(Branch::class, ['id' => 'idbranch'])
			->via('req');
	}
	public function getStatus()
	{
	    return $this->hasOne(Status::class, ['id' => 'idstatus'])
			->via('req');
	}
	public function getKam()
	{
	    return $this->hasOne(Profile::class, ['iduser' => 'idkam'])
			->via('user');
	}
}
