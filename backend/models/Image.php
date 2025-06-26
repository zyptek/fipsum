<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $caption
 * @property int $active
 * @property int $idcat
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Imagecat $idcat0
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
            [['name', 'caption'], 'required'],
            [['path'], 'required', 'message' => 'Debe seleccionar un archivo.'],
            [['idcat'], 'required', 'message' => 'Por favor seleccione una categoría.'],
            [['active', 'idcat'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['path', 'caption'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 245],
            [['idcat'], 'exist', 'skipOnError' => true, 'targetClass' => Imagecat::class, 'targetAttribute' => ['idcat' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Ruta',
            'name' => 'Name',
            'caption' => 'Caption',
            'active' => 'Active',
            'idcat' => 'Idcat',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Idcat0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Imagecat::class, ['id' => 'idcat']);
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
