<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ImageTable]].
 *
 * @see ImageTable
 */
class ImageTableQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ImageTable[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ImageTable|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
