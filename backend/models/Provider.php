<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "provider".
 *
 * @property int $id
 * @property string $name
 * @property string|null $altname
 * @property string|null $rut
 * @property string|null $giro
 * @property int|null $idregion
 * @property string $city
 * @property int|null $idcity
 * @property string $address
 * @property string $contact
 * @property string|null $phone
 * @property string $email
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 * @property int $margin
 *
 * @property City $idcity0
 * @property Region $idregion0
 * @property Ocomp[] $ocomps
 * @property Pquote[] $pquotes
 */
class Provider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city', 'address', 'contact', 'email'], 'required'],
            [['idregion', 'idcity', 'active', 'margin'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'altname', 'city', 'address'], 'string', 'max' => 45],
            [['rut'], 'string', 'max' => 12],
            [['giro', 'contact', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 11],
            [['idcity'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['idcity' => 'id']],
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
            'name' => 'Name',
            'altname' => 'Nombre de Fantasia',
            'rut' => 'Rut',
            'giro' => 'Giro',
            'idregion' => 'Idregion',
            'city' => 'Ciudad',
            'idcity' => 'Idcity',
            'address' => 'Dirección',
            'contact' => 'Contacto',
            'phone' => 'Telefono',
            'email' => 'Email',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'margin' => 'Margin',
        ];
    }

    /**
     * Gets query for [[Idcity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdcity0()
    {
        return $this->hasOne(City::class, ['id' => 'idcity']);
    }

    /**
     * Gets query for [[Idregion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdregion0()
    {
        return $this->hasOne(Region::class, ['id' => 'idregion']);
    }

    /**
     * Gets query for [[Ocomps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOcomps()
    {
        return $this->hasMany(Ocomp::class, ['idprovider' => 'id']);
    }

    /**
     * Gets query for [[Pquotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPquotes()
    {
        return $this->hasMany(Pquote::class, ['idprovider' => 'id']);
    }
}
