<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Pquote]].
 *
 * @see Pquote
 */
class PquoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pquote[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pquote|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
