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

    public function run()
    {
        // Obtiene las relaciones desde la tabla image_table
        $relations = ImageTable::find()
            ->where(['table_name' => $this->relatedModel, 'idtable' => $this->relatedId])
            ->all();

        if (!$relations) {
            return '<p>No hay imágenes relacionadas.</p>';
        }

        $output = '<div class="image-gallery">';
        foreach ($relations as $relation) {
            $image = Image::findOne($relation->idimage);
            if ($image) {
                $imagePath = '/uploads/' . $image->path;
                $deleteUrl = Url::to(['image/delete', 'id' => $image->id]); // Ruta de eliminación
                $lightboxId = 'lightbox-' . $image->id; // ID único para el lightbox

                $output .= Html::tag('div', 
                    // Enlace para el lightbox
                    Html::a(Html::img($imagePath, ['class' => 'thumbnail', 'alt' => $image->name]), $imagePath, [
    'data-fancybox' => 'gallery',
    'data-caption' => $image->name,
]) .
                    // Botón de eliminar
                    Html::a('Eliminar', $deleteUrl, [
                        'class' => 'btn btn-danger btn-sm delete-button',
                        'data-method' => 'post', // Envía el método POST para eliminar
                        'data-confirm' => '¿Estás seguro de que deseas eliminar esta imagen?',
                    ]),
                    ['class' => 'image-item']
                );
            }
        }
        $output .= '</div>';

        return $output;
    }
}
