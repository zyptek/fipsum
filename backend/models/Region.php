<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property int $idcountry
 * @property string $name
 *
 * @property City[] $cities
 * @property Country $idcountry0
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idcountry', 'name'], 'required'],
            [['id', 'idcountry'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['idcountry'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['idcountry' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idcountry' => 'Id País',
            'name' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['idregion' => 'id']);
    }

    /**
     * Gets query for [[Idcountry0]].
     *
     * @return \yii\db\ActiveQuery|CountryQuery
     */
#    public function getIdcountry0()
	public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'idcountry']);
    }

    /**
     * {@inheritdoc}
     * @return RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegionQuery(get_called_class());
    }
}
