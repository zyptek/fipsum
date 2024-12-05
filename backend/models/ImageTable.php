<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "image_table".
 *
 * @property int $idimage
 * @property string $table_name
 * @property int $idtable
 */
class ImageTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idimage', 'table_name', 'idtable'], 'required'],
            [['idimage', 'idtable'], 'integer'],
            [['table_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idimage' => 'Idimage',
            'table_name' => 'Table Name',
            'idtable' => 'Idtable',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ImageTableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageTableQuery(get_called_class());
    }
}
