<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Poc]].
 *
 * @see Poc
 */
class PocQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Poc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Poc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
