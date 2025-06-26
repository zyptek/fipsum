<?php

namespace backend\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "req".
 *
 * @property int $id
 * @property string $nst ST o Ticket
 * @property string|null $nceco
 * @property string $inidetail
 * @property string|null $description
 * @property int $estdays
 * @property int $idactivity
 * @property int $idtos
 * @property int $idstatus
 * @property int $idkam
 * @property int $idbranch
 * @property int $idsolicitor
 * @property int $idcompany
 * @property int|null $tecasigned
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Activity $idactivity0
 * @property Branch $idbranch0
 * @property Company $idcompany0
 * @property Kam $idkam0
 * @property Solicitor $idsolicitor0
 * @property Status $idstatus0
 * @property Tos $idtos0
 * @property Pquote[] $pquotes
 * @property Reqhist[] $reqhists
 * @property SquoteDetail[] $squoteDetails
 * @property Squote[] $squotes
 * @property User $tecasigned0
 */
class Req extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'req';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inidetail', 'estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor', 'idcompany'], 'required'],
            [['inidetail', 'description'], 'string'],
            [['estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor', 'idcompany', 'tecasigned'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nst', 'nceco'], 'string', 'max' => 20],
            [['idactivity'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::class, 'targetAttribute' => ['idactivity' => 'id']],
            [['idbranch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::class, 'targetAttribute' => ['idbranch' => 'id']],
            [['idcompany'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['idcompany' => 'id']],
            [['idkam'], 'exist', 'skipOnError' => true, 'targetClass' => Kam::class, 'targetAttribute' => ['idkam' => 'id']],
            [['idsolicitor'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitor::class, 'targetAttribute' => ['idsolicitor' => 'id']],
            [['idstatus'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['idstatus' => 'id']],
            [['idtos'], 'exist', 'skipOnError' => true, 'targetClass' => Tos::class, 'targetAttribute' => ['idtos' => 'id']],
            [['tecasigned'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tecasigned' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Nº Req',
            'nst' => 'Nº ST',
            'nceco' => 'CECO',
            'inidetail' => 'Detalle',
            'description' => 'Descripción',
            'estdays' => 'Tiempo Estimado (Dias)',
            'idactivity' => 'Actividad',
            'idtos' => 'Tipo de Venta',
            'idstatus' => 'Status',
            'idkam' => 'Administrador de Cuentas',
            'idbranch' => 'Sucursal',
            'idsolicitor' => 'Solicitante',
            'idcompany' => 'Cliente',
            'tecasigned' => 'Técnico Asignado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
            'companyBranch' => 'Cliente',
			'statusCol' => 'Status',
			'kamCol' => 'Admin Cta',
			'tosCol' => 'Tipo de Venta',
			'activityCol' => 'Actividad',
			'solicitorCol' => 'Solicitante',
			'estdaysCol' => 'Tiempo Estimado (Dias)',
			'createdCol' => 'Fecha Ingreso',
			'timeCol' => 'Tiempo',
			'cotiCol' => 'Coti.',
        ];
    }

    /**
     * Gets query for [[Idactivity0]].
     *
     * @return \yii\db\ActiveQuery|ActivityQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['id' => 'idactivity']);
    }

    /**
     * Gets query for [[Idbranch0]].
     *
     * @return \yii\db\ActiveQuery|BranchQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'idbranch']);
    }

    /**
     * Gets query for [[Idcompany0]].
     *
     * @return \yii\db\ActiveQuery|CompanyQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'idcompany']);
    }

    /**
     * Gets query for [[Idkam0]].
     *
     * @return \yii\db\ActiveQuery|KamQuery
     */
    public function getKam()
    {
        return $this->hasOne(User::class, ['id' => 'idkam']);
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['iduser' => 'idkam']);
    }
    /**
     * Gets query for [[Idsolicitor0]].
     *
     * @return \yii\db\ActiveQuery|SolicitorQuery
     */
    public function getSolicitor()
    {
        return $this->hasOne(Solicitor::class, ['id' => 'idsolicitor']);
    }

    /**
     * Gets query for [[Idstatus0]].
     *
     * @return \yii\db\ActiveQuery|StatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'idstatus']);
    }

    /**
     * Gets query for [[Idtos0]].
     *
     * @return \yii\db\ActiveQuery|TosQuery
     */
    public function getTos()
    {
        return $this->hasOne(Tos::class, ['id' => 'idtos']);
    }

    /**
     * Gets query for [[Pquotes]].
     *
     * @return \yii\db\ActiveQuery|PquoteQuery
     */
    public function getPquotes()
    {
        return $this->hasMany(Pquote::class, ['idreq' => 'id']);
    }
    /**
     * Gets query for [[Reqhists]].
     *
     * @return \yii\db\ActiveQuery|ReqhistQuery
     */
    public function getReqhists()
    {
        return $this->hasMany(Reqhist::class, ['idreq' => 'id']);
    }

    /**
     * Gets query for [[SquoteDetails]].
     *
     * @return \yii\db\ActiveQuery|SquoteDetailQuery
     */
    public function getSquoteDetails()
    {
        return $this->hasMany(SquoteDetail::class, ['idreq' => 'id']);
    }

    /**
     * Gets query for [[Squotes]].
     *
     * @return \yii\db\ActiveQuery|SquoteQuery
     */
    public function getSquotes()
    {
        return $this->hasMany(Squote::class, ['idreq' => 'id']);
    }


    /**
     * Gets query for [[Tecasigned0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getTecnico()
    {
        return $this->hasOne(Profile::class, ['iduser' => 'tecasigned']);
    }

    /**
     * {@inheritdoc}
     * @return ReqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReqQuery(get_called_class());
    }
}
