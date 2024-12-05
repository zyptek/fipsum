<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Reqhist]].
 *
 * @see Reqhist
 */
class ReqhistQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Reqhist[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Reqhist|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
