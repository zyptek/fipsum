<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Ocomp]].
 *
 * @see Ocomp
 */
class OcompQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ocomp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ocomp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
