<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "inftec_image".
 *
 * @property int $id
 * @property int $idit
 * @property int $idimage
 * @property string $created_at
 *
 * @property Image $idimage0
 * @property Inftec $idit0
 */
class InftecImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inftec_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idit', 'idimage'], 'required'],
            [['idit', 'idimage'], 'integer'],
            [['created_at'], 'safe'],
            [['idimage'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['idimage' => 'id']],
            [['idit'], 'exist', 'skipOnError' => true, 'targetClass' => Inftec::class, 'targetAttribute' => ['idit' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idit' => 'Idit',
            'idimage' => 'Idimage',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Idimage0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdimage0()
    {
        return $this->hasOne(Image::class, ['id' => 'idimage']);
    }

    /**
     * Gets query for [[Idit0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdit0()
    {
        return $this->hasOne(Inftec::class, ['id' => 'idit']);
    }
}
