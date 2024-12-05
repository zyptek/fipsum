<?php
	
namespace backend\components;

use yii\widgets\LinkPager;

class CustomPagination extends LinkPager
{
    public $firstPageLabel = 'Inicio';
    public $lastPageLabel = 'Fin';
    public $prevPageLabel = '«';
    public $nextPageLabel = '»';
    public $options = ['class' => 'pagination'];
}