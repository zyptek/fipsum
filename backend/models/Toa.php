<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "toa".
 *
 * @property int $id
 * @property string $name
 *
 * @property Alloc[] $allocs
 */
class Toa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toa';
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
     * Gets query for [[Allocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllocs()
    {
        return $this->hasMany(Alloc::class, ['idtoa' => 'id']);
    }
}
