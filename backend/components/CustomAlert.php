<?php 

namespace backend\components;

use hail812\adminlte\widgets\Alert;

class CustomAlert extends Alert
{
    /**
     * Mapea los tipos de alertas a encabezados en español.
     */
    private $headerTitles = [
        'success' => 'Éxito',
        'info' => 'Información',
        'danger' => 'Error',
        'warning' => 'Advertencia',
    ];

    /**
     * Ejecuta y personaliza la salida del widget.
     */
    public function run()
    {
        // Obtener el encabezado traducido según el tipo de alerta
        $header = $this->headerTitles[$this->type] ?? 'Alerta';

        // Renderizar la alerta con encabezado traducido
        return '<div class="alert alert-' . $this->type . ' alert-dismissible">'
            . '<h5><i class="icon fas fa-' . $this->getIcon($this->type) . '"></i> ' . $header . '</h5>'
            . $this->body
            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
            . '</div>';
    }

    /**
     * Retorna un ícono apropiado según el tipo de alerta.
     */
    private function getIcon($type)
    {
        $icons = [
            'success' => 'check',
            'info' => 'info',
            'danger' => 'ban',
            'warning' => 'exclamation-triangle',
        ];
        return $icons[$type] ?? 'bell';
    }
}
