<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "provider_region".
 *
 * @property int $id
 * @property int $idprovider
 * @property int $idregion
 */
class ProviderRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idprovider', 'idregion'], 'required'],
            [['idprovider', 'idregion'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idprovider' => 'Idprovider',
            'idregion' => 'Idregion',
        ];
    }
}
