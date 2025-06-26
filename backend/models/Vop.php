<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vop".
 *
 * @property int $id
 * @property string $name
 *
 * @property Ocomp[] $ocomps
 */
class Vop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * Gets query for [[Ocomps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOcomps()
    {
        return $this->hasMany(Ocomp::class, ['idvop' => 'id']);
    }
}
