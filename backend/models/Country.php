<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $phonecode
 * @property string $updated_at
 * @property string $created_at
 *
 * @property City[] $cities
 * @property Region[] $regions
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['phonecode'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 3],
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
            'code' => 'Código',
            'phonecode' => 'Código País',
            'updated_at' => 'Actualizado',
            'created_at' => 'Creado',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['idcountry' => 'id']);
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery|RegionQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::class, ['idcountry' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
