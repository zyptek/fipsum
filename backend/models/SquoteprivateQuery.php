<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Squoteprivate]].
 *
 * @see Squoteprivate
 */
class SquoteprivateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Squoteprivate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Squoteprivate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
