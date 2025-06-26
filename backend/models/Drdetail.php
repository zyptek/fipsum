<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "drdetail".
 *
 * @property int $id
 * @property int $iddocrend
 * @property int $idtoe
 * @property int $doc_no
 * @property string $date
 * @property string $name
 * @property string $company
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Docrend $iddocrend0
 * @property Toe $idtoe0
 */
class Drdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddocrend', 'idtoe', 'doc_no', 'date', 'name', 'company', 'amount'], 'required'],
            [['iddocrend', 'idtoe', 'doc_no', 'amount'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['company'], 'string', 'max' => 45],
            [['iddocrend'], 'exist', 'skipOnError' => true, 'targetClass' => Docrend::class, 'targetAttribute' => ['iddocrend' => 'id']],
            [['idtoe'], 'exist', 'skipOnError' => true, 'targetClass' => Toe::class, 'targetAttribute' => ['idtoe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iddocrend' => 'Iddocrend',
            'idtoe' => 'Idtoe',
            'doc_no' => 'Doc No',
            'date' => 'Date',
            'name' => 'Name',
            'company' => 'Company',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Iddocrend0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocrend()
    {
        return $this->hasOne(Docrend::class, ['id' => 'iddocrend']);
    }

    /**
     * Gets query for [[Idtoe0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToe()
    {
        return $this->hasOne(Toe::class, ['id' => 'idtoe']);
    }
}
