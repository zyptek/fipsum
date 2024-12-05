<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property string|null $name
 * @property int $idcompany
 * @property int|null $idregion
 * @property string|null $city
 * @property string|null $address
 *
 * @property Company $idcompany0
 * @property Region $idregion0
 * @property Req[] $reqs
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcompany'], 'required'],
            [['idcompany', 'idregion'], 'integer'],
            [['name'], 'string', 'max' => 38],
            [['city'], 'string', 'max' => 26],
            [['address'], 'string', 'max' => 240],
            [['idcompany'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['idcompany' => 'id']],
            [['idregion'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['idregion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'idcompany' => 'Compañía',
            'idregion' => 'Región',
            'city' => 'Ciudad',
            'address' => 'Dirección',
        ];
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
     * Gets query for [[Idregion0]].
     *
     * @return \yii\db\ActiveQuery|RegionQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'idregion']);
    }

    /**
     * Gets query for [[Reqs]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReqs()
    {
        return $this->hasMany(Req::class, ['idbranch' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BranchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BranchQuery(get_called_class());
    }
}
