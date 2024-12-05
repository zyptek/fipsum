<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property int $idcountry
 * @property int $idregion
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Country $idcountry0
 * @property Region $idregion0
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idcountry', 'idregion'], 'required'],
            [['idcountry', 'idregion'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['idcountry'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['idcountry' => 'id']],
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
            'idcountry' => 'Id País',
            'idregion' => 'Id Región',
            'updated_at' => 'Actualizado',
            'created_at' => 'Creado',
        ];
    }

    /**
     * Gets query for [[Idcountry0]].
     *
     * @return \yii\db\ActiveQuery|CountryQuery
     */
#    public function getIdcountr()
	public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'idcountry']);
    }

    /**
     * Gets query for [[Idregion0]].
     *
     * @return \yii\db\ActiveQuery|RegionQuery
     */
    public function getIdregion0()
    {
        return $this->hasOne(Region::class, ['id' => 'idregion']);
    }

    /**
     * {@inheritdoc}
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
