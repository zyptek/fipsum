<?php

namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\ImageTable;
use backend\models\Image;

class ImageGalleryWidget extends Widget
{
    public $relatedId; // ID del modelo relacionado
    public $relatedModel; // Nombre de la tabla o modelo relacionado
    public $type = 'all';
    public $check = false;

	
    public function run()
    {
        $relations = ImageTable::find()
            ->where(['tablename' => $this->relatedModel, 'idtable' => $this->relatedId])
            ->all();

        if (!$relations) {
            return '<p>No hay imágenes relacionadas.</p>';
        }

        $deleteUrl = Url::to(['image/delete']);
        $output = "<div class='image-gallery' data-delete-url='{$deleteUrl}'>";
        $hasImages = false;
        
        $selectedImages = is_array($this->check) ? $this->check : [];
        
        foreach ($relations as $relation) {
            $query = Image::find()->where(['id' => $relation->idimage]);
            if ($this->type == 'doc') {
                $query->andWhere(['between', 'idcat', 5, 7]);
            } elseif ($this->type == 'img') {
                $query->andWhere(['<', 'idcat', 5]);
            }
            $image = $query->one();
            
            if ($image) {
                $hasImages = true;
                $imagePath = '/uploads/' . $image->path;
                $imageId = $image->id;
                
				$isChecked = in_array($imageId, $selectedImages) ? true : false;
                
                $checkbox = is_array($this->check) ? Html::checkbox('images[]', $isChecked, [
                    'value' => $imageId,
                    'class' => 'image-checkbox'
                ]) : '';
				
				$deleteBtn = !$this->check ? Html::button('<i class="fas fa-trash"></i>', [
                        'class' => 'btn btn-danger btn-sm delete-button',
                        'data-id' => $imageId,
                    ]) : '';
                $output .= Html::tag('div', 
                    Html::a(Html::img($imagePath, ['class' => 'thumbnail', 'alt' => $image->name]), $imagePath, [
                        'data-fancybox' => 'gallery',
                        'data-caption' => $image->name,
                    ]) .
                    $checkbox .
                    $deleteBtn,
                    ['class' => 'image-item', 'id' => 'image-'.$imageId]
                );
            }
        }
        
        if (!$hasImages) return '<p>No hay imágenes relacionadas.</p>';
        
        $output .= '</div>';
        $this->getView()->registerJsFile('@web/js/upload_file.js', [
            'depends' => ['yii\web\JqueryAsset'],
            'position' => \yii\web\View::POS_END,
        ]);

        return $output;
    }
}

