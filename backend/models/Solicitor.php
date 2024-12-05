<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "solicitor".
 *
 * @property int $id
 * @property string $name
 * @property int $idcompany
 *
 * @property Company $idcompany0
 * @property Req[] $reqs
 */
class Solicitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idcompany'], 'required'],
            [['idcompany'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['idcompany'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['idcompany' => 'id']],
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
     * Gets query for [[Reqs]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReqs()
    {
        return $this->hasMany(Req::class, ['idsolicitor' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SolicitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SolicitorQuery(get_called_class());
    }
}
