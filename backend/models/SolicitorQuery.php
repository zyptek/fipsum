<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Solicitor]].
 *
 * @see Solicitor
 */
class SolicitorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Solicitor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Solicitor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
