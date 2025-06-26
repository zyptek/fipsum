<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "squote".
 *
 * @property int $id
 * @property int $idreq
 * @property int $idpquote
 * @property int|null $idstatus
 * @property int $noc
 * @property int|null $mc
 * @property float|null $cmp
 * @property int|null $subtotal
 * @property int|null $gg
 * @property int|null $neto
 * @property int|null $iva
 * @property int|null $total
 * @property int|null $accepted
 * @property int|null $author_accepted
 * @property string|null $date_accepted
 * @property int|null $approved_f
 * @property int|null $approved_c
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Pquote $idpquote0
 * @property Req $idreq0
 * @property SquoteStatus $idstatus0
 * @property SquoteDetail[] $squoteDetails
 * @property Squoteprivate $squoteprivate
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
            [['idreq', 'idpquote', 'noc'], 'required'],
            [['idreq', 'idpquote', 'idstatus', 'noc', 'mc', 'subtotal', 'gg', 'neto', 'iva', 'total', 'accepted', 'author_accepted', 'approved_f', 'approved_c'], 'integer'],
            [['cmp'], 'number'],
            [['date_accepted', 'created_at', 'updated_at'], 'safe'],
            [['idpquote'], 'exist', 'skipOnError' => true, 'targetClass' => Pquote::class, 'targetAttribute' => ['idpquote' => 'id']],
            [['idreq'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idreq' => 'id']],
            [['idstatus'], 'exist', 'skipOnError' => true, 'targetClass' => SquoteStatus::class, 'targetAttribute' => ['idstatus' => 'id']],
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
            'idpquote' => 'Cotización',
            'idstatus' => 'Status',
            'noc' => 'Noc',
            'mc' => 'Mc',
            'cmp' => 'Cmp',
            'subtotal' => 'Subtotal',
            'gg' => 'GG',
            'neto' => 'Neto',
            'iva' => 'Iva',
            'total' => 'Total',
            'accepted' => 'Accepted',
            'author_accepted' => 'Author Accepted',
            'date_accepted' => 'Date Accepted',
            'approved_f' => 'Approved F',
            'approved_c' => 'Approved C',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
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
     * Gets query for [[Idstatus0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(SquoteStatus::class, ['id' => 'idstatus']);
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
     * Gets query for [[Squoteprivate]].
     *
     * @return \yii\db\ActiveQuery|SquoteprivateQuery
     */
    public function getSquoteprivate()
    {
        return $this->hasOne(Squoteprivate::class, ['idsquote' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SquoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SquoteQuery(get_called_class());
    }
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

/*	
	public function getStatus()
	{
	    return $this->hasOne(Status::class, ['id' => 'idstatus'])
			->via('req');
	}
*/
/*
	public function getKam()
	{
	    return $this->hasOne(Profile::class, ['iduser' => 'idkam'])
			->via('user');
	}
*/

}
