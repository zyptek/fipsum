<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "provider".
 *
 * @property int $id
 * @property string $name
 * @property int $idregion
 * @property string $city
 * @property string $address
 * @property string $contact
 * @property string $email
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
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
            [['name', 'idregion', 'city', 'address', 'contact', 'email', 'active'], 'required'],
            [['idregion', 'active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'city', 'address'], 'string', 'max' => 45],
            [['contact', 'email'], 'string', 'max' => 100],
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
            'idregion' => 'Idregion',
            'city' => 'City',
            'address' => 'Address',
            'contact' => 'Contact',
            'email' => 'Email',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProviderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProviderQuery(get_called_class());
    }
}
