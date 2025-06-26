<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "squote_status".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 *
 * @property Squote[] $squotes
 */
class SquoteStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'squote_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
     * Gets query for [[Squotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSquotes()
    {
        return $this->hasMany(Squote::class, ['idstatus' => 'id']);
    }
}
