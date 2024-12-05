<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "req".
 *
 * @property int $id
 * @property string $idalt ST o Ticket
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
 * @property Reqhist[] $reqhists
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
            [['idalt', 'inidetail', 'estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor', 'idcompany'], 'required'],
            [['inidetail', 'description'], 'string'],
            [['estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor', 'idcompany'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['idalt'], 'string', 'max' => 20],
            [['idactivity'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::class, 'targetAttribute' => ['idactivity' => 'id']],
            [['idbranch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::class, 'targetAttribute' => ['idbranch' => 'id']],
            [['idcompany'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['idcompany' => 'id']],
            [['idkam'], 'exist', 'skipOnError' => true, 'targetClass' => Kam::class, 'targetAttribute' => ['idkam' => 'id']],
            [['idsolicitor'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitor::class, 'targetAttribute' => ['idsolicitor' => 'id']],
            [['idstatus'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['idstatus' => 'id']],
            [['idtos'], 'exist', 'skipOnError' => true, 'targetClass' => Tos::class, 'targetAttribute' => ['idtos' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Nº IT',
            'idalt' => 'N° ST',
            'inidetail' => 'Detalle',
            'description' => 'Descripción',
            'estdays' => 'Tiempo Estimado',
            'idactivity' => 'Actividad',
            'idtos' => 'Tipo de Venta',
            'idstatus' => 'Status',
            'idkam' => 'Administrador de Cuentas',
            'idbranch' => 'Sucursal',
            'idsolicitor' => 'Solicitante',
            'idcompany' => 'Cliente',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        return $this->hasOne(Kam::class, ['id' => 'idkam']);
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
     * Gets query for [[Reqhists]].
     *
     * @return \yii\db\ActiveQuery|ReqhistQuery
     */
    public function getReqhist()
    {
        return $this->hasMany(Reqhist::class, ['idreq' => 'id']);
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
