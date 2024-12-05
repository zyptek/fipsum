<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name
 * @property string $bgcolor
 *
 * @property Req[] $reqs
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'bgcolor'], 'required'],
            [['name', 'bgcolor'], 'string', 'max' => 50],
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
            'bgcolor' => 'Bgcolor',
        ];
    }

    /**
     * Gets query for [[Reqs]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReqs()
    {
        return $this->hasMany(Req::class, ['idstatus' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatusQuery(get_called_class());
    }
}
