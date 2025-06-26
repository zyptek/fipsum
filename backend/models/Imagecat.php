<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "imagecat".
 *
 * @property int $id
 * @property string $name
 * @property int $idrole
 *
 * @property Role $idrole0
 */
class Imagecat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagecat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idrole'], 'required'],
            [['idrole'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['idrole'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['idrole' => 'id']],
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
            'idrole' => 'Idrole',
        ];
    }

    /**
     * Gets query for [[Idrole0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdrole0()
    {
        return $this->hasOne(Role::class, ['id' => 'idrole']);
    }
}
