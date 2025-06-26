<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "constants".
 *
 * @property int $id
 * @property int $gtkms
 * @property int $hhdtec
 * @property int $hhdls2
 * @property int $hhntec
 * @property int $hhnls2
 * @property int $bxztec
 * @property int $bxzls2
 * @property float $ggu
 * @property string $created_at
 */
class Constants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'constants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gtkms', 'hhdtec', 'hhdls2', 'hhntec', 'hhnls2', 'bxztec', 'bxzls2', 'ggu'], 'required'],
            [['gtkms', 'hhdtec', 'hhdls2', 'hhntec', 'hhnls2', 'bxztec', 'bxzls2'], 'integer'],
            [['ggu'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gtkms' => 'Gtkms',
            'hhdtec' => 'Hhdtec',
            'hhdls2' => 'Hhdls2',
            'hhntec' => 'Hhntec',
            'hhnls2' => 'Hhnls2',
            'bxztec' => 'Bxztec',
            'bxzls2' => 'Bxzls2',
            'ggu' => 'Ggu',
            'created_at' => 'Created At',
        ];
    }
}
