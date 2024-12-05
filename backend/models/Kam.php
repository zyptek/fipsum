<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kam".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 *
 * @property Req[] $reqs
 */
class Kam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 20],
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
            'alias' => 'Alias',
        ];
    }

    /**
     * Gets query for [[Reqs]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getReqs()
    {
        return $this->hasMany(Req::class, ['idkam' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return KamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KamQuery(get_called_class());
    }
}
