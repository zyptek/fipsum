<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Histtype]].
 *
 * @see Histtype
 */
class HisttypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Histtype[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Histtype|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
