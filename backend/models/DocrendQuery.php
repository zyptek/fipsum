<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Docrend]].
 *
 * @see Docrend
 */
class DocrendQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Docrend[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Docrend|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
