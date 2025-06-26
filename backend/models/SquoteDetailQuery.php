<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SquoteDetail]].
 *
 * @see SquoteDetail
 */
class SquoteDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SquoteDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SquoteDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
