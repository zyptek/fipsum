<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tos".
 *
 * @property int $id
 * @property string $name
 *
 * @property Req[] $reqs
 */
class Tos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tos';
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
     * Gets query for [[Reqs]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReqs()
    {
        return $this->hasMany(Req::class, ['idtos' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TosQuery(get_called_class());
    }
}
