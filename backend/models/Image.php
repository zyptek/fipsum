<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'name'], 'required'],
            [['active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 245],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageQuery(get_called_class());
    }
}
