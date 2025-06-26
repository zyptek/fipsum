<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "image_table".
 *
 * @property int $id
 * @property int $idimage
 * @property string $tablename
 * @property int $idtable
 *
 * @property Image $idimage0
 * @property Req $idtable0
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
            [['idimage', 'tablename', 'idtable'], 'required'],
            [['idimage', 'idtable'], 'integer'],
            [['tablename'], 'string', 'max' => 255],
            [['idimage'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['idimage' => 'id']],
            [['idtable'], 'exist', 'skipOnError' => true, 'targetClass' => Req::class, 'targetAttribute' => ['idtable' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idimage' => 'Idimage',
            'tablename' => 'Tablename',
            'idtable' => 'Idtable',
        ];
    }

    /**
     * Gets query for [[Idimage0]].
     *
     * @return \yii\db\ActiveQuery|ImageQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'idimage']);
    }

    /**
     * Gets query for [[Idtable0]].
     *
     * @return \yii\db\ActiveQuery|ReqQuery
     */
    public function getTable()
    {
        return $this->hasOne(Req::class, ['id' => 'idtable']);
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
