<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Tos]].
 *
 * @see Tos
 */
class TosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
