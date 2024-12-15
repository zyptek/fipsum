<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserModule]].
 *
 * @see UserModule
 */
class UserModuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserModule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserModule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
