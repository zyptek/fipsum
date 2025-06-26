<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "allocstatus".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 *
 * @property Alloc[] $allocs
 */
class Allocstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allocstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
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
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Allocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllocs()
    {
        return $this->hasMany(Alloc::class, ['idallocstatus' => 'id']);
    }
}
