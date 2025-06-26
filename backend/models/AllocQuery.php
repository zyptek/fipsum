<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Alloc]].
 *
 * @see Alloc
 */
class AllocQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Alloc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Alloc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
