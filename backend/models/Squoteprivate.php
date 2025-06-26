<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "squoteprivate".
 *
 * @property int $id
 * @property int $idsquote
 * @property int|null $mat-tot
 * @property string|null $mat-desc
 * @property int|null $gt-peaje
 * @property int|null $gt-estac
 * @property int|null $gt-km
 * @property int|null $gt-tot
 * @property float|null $hhd-tec
 * @property float|null $hhd-ls2
 * @property int|null $hhd-dias
 * @property int $hhd-tot
 * @property float|null $hhn-tec
 * @property float|null $hhn-ls2
 * @property int|null $hhn-dias
 * @property int $hhn-tot
 * @property float|null $bxz-tec
 * @property float|null $bxz-ls2
 * @property int|null $bxz-dias
 * @property int $bxz-tot
 * @property int|null $ayc-aloj
 * @property int|null $ayc-col
 * @property int|null $ayc-dias
 * @property int $ayc-tot
 * @property int $rtotal
 * @property float|null $mcpct
 * @property int|null $mc
 * @property int|null $ven-cos
 * @property string $created_at
 *
 * @property Squote $idsquote0
 */
class Squoteprivate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'squoteprivate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsquote'], 'required'],
            [['idsquote', 'mat-tot', 'gt-peaje', 'gt-estac', 'gt-km', 'gt-tot', 'hhd-dias', 'hhd-tot', 'hhn-dias', 'hhn-tot', 'bxz-dias', 'bxz-tot', 'ayc-aloj', 'ayc-col', 'ayc-dias', 'ayc-tot', 'rtotal', 'mc', 'ven-cos'], 'integer'],
            [['hhd-tec', 'hhd-ls2', 'hhn-tec', 'hhn-ls2', 'bxz-tec', 'bxz-ls2', 'mcpct'], 'number'],
            [['created_at'], 'safe'],
            [['mat-desc'], 'string', 'max' => 100],
            [['idsquote'], 'unique'],
            [['idsquote'], 'exist', 'skipOnError' => true, 'targetClass' => Squote::class, 'targetAttribute' => ['idsquote' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
                'id' => 'ID',
            'idsquote' => 'Idsquote',
            'mat-tot' => 'Total Materiales',
            'mat-desc' => 'Descripción Materiales',
            'gt-peaje' => 'Gt Peajes',
            'gt-estac' => 'Gt Estacionamiento',
            'gt-km' => 'Gt Kms',
            'gt-tot' => 'Gt Total',
            'hhd-tec' => 'Hhd Técnicos',
            'hhd-ls2' => 'Hhd Ls2',
            'hhd-dias' => 'Hhd Días',
            'hhd-tot' => 'Hhd Total',
            'hhn-tec' => 'Hhn Técnicos',
            'hhn-ls2' => 'Hhn Ls2',
            'hhn-dias' => 'Hhn Días',
            'hhn-tot' => 'Hhn Total',
            'bxz-tec' => 'Bxz Tec',
            'bxz-ls2' => 'Bxz Ls2',
            'bxz-dias' => 'Bxz Días',
            'bxz-tot' => 'Bxz Total',
            'ayc-aloj' => 'Ayc Alojamiento',
            'ayc-col' => 'Ayc Colacion',
            'ayc-dias' => 'Ayc Días',
            'ayc-tot' => 'Ayc Total',
            'rtotal' => 'Rtotal',
            'mcpct' => 'Mcpct',
            'mc' => 'Mc',
            'ven-cos' => 'Ven Cos',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Idsquote0]].
     *
     * @return \yii\db\ActiveQuery|SquoteQuery
     */
    public function getIdsquote0()
    {
        return $this->hasOne(Squote::class, ['id' => 'idsquote']);
    }

    /**
     * {@inheritdoc}
     * @return SquoteprivateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SquoteprivateQuery(get_called_class());
    }
}
