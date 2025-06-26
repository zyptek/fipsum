<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Squote]].
 *
 * @see Squote
 */
class SquoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Squote[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Squote|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
