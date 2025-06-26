<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Inftec]].
 *
 * @see Inftec
 */
class InftecQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Inftec[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Inftec|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
