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
	public $isDoc = false;
	
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
        foreach ($relations as $relation) {
	        if($this->isDoc == true){
            	$image = Image::find()->where(['id' => $relation->idimage])->andWhere(['between','idcat', 5, 7])->one();
            	
            }else{
	            # $image = Image::findOne($relation->idimage);
	            $image = Image::find()->where(['id' => $relation->idimage])->andWhere(['<','idcat', 5])->one();

            }
            if ($image) {
	            if($image) $hasImages = true;
                $imagePath = '/uploads/' . $image->path;
                $deleteUrl = Url::to(['image/delete', 'id' => $image->id]); // Ruta de eliminación
                $lightboxId = 'lightbox-' . $image->id; // ID único para el lightbox
				$imageId = $image->id;
				
                $output .= Html::tag('div', 
                    // Enlace para el lightbox
                    Html::a(Html::img($imagePath, ['class' => 'thumbnail', 'alt' => $image->name, ]), $imagePath, [
    'data-fancybox' => 'gallery',
    'data-caption' => $image->name,
]) .
                    // Botón de eliminar
                    Html::button('<i class="fas fa-trash"></i>', [
                        'class' => 'btn btn-danger btn-sm delete-button',
                        'data-id' => $imageId,
                    ]),
                    ['class' => 'image-item', 'id' => 'image-'.$imageId]
                );
            }
        }
        if(!$hasImages) return '<p>No hay imágenes relacionadas.</p>';
        
        $output .= '</div>';
		$this->getView()->registerJsFile('@web/js/upload_file.js',[
    'depends' => ['yii\web\JqueryAsset'], // Asegura que jQuery se cargue primero
    'position' => \yii\web\View::POS_END, // Carga el script al final
]);

        return $output;
    }
}
