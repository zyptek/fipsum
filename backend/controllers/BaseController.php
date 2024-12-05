<?php

namespace backend\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    public function render($view, $params = [])
    {
        \Yii::$container->set('yii\widgets\LinkPager', [
            'class' => 'backend\components\CustomPagination',
        ]);

        return parent::render($view, $params);
    }
}
