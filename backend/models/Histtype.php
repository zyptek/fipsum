<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "histtype".
 *
 * @property int $id
 * @property string $name
 *
 * @property Reqhist[] $reqhists
 */
class Histtype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'histtype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
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
     * Gets query for [[Reqhists]].
     *
     * @return \yii\db\ActiveQuery|ReqhistQuery
     */
    public function getReqhists()
    {
        return $this->hasMany(Reqhist::class, ['idhisttype' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return HisttypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HisttypeQuery(get_called_class());
    }
}
