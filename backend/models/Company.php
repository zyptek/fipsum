<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property int $idregion
 * @property int $branches
 * @property int $active
 *
 * @property Branch[] $branches0
 * @property Region $idregion0
 * @property Req[] $reqs
 * @property Solicitor[] $solicitors
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'branches'], 'required'],
            [['idregion', 'branches', 'active'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['alias'], 'string', 'max' => 10],
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
            'alias' => 'Alias',
            'idregion' => 'Region',
            'branches' => 'Sucursales',
            'active' => 'Activa',
        ];
    }

    /**
     * Gets query for [[Branches0]].
     *
     * @return \yii\db\ActiveQuery|BranchQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::class, ['idcompany' => 'id']);
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
        return $this->hasMany(Req::class, ['idcompany' => 'id']);
    }

    /**
     * Gets query for [[Solicitors]].
     *
     * @return \yii\db\ActiveQuery|SolicitorQuery
     */
    public function getSolicitors()
    {
        return $this->hasMany(Solicitor::class, ['idcompany' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }
}
