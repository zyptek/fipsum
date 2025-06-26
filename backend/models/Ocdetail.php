<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ocdetail".
 *
 * @property int $id
 * @property int $idocomp
 * @property string $description
 * @property int $qty
 * @property int $uprice
 * @property string $created_at
 */
class Ocdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ocdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idocomp', 'description', 'qty', 'uprice'], 'required'],
            [['id', 'idocomp', 'qty', 'uprice'], 'integer'],
            [['created_at'], 'safe'],
            [['description'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idocomp' => 'Idocomp',
            'description' => 'Description',
            'qty' => 'Qty',
            'uprice' => 'Uprice',
            'created_at' => 'Created At',
        ];
    }
}
