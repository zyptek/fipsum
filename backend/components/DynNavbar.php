<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;

class DynNavbar extends Component
{
    public $profile; // modelo Profile (inyectado o seteado manualmente)

    public function renderMenu($menuArr)
	{
	    $output = ''; 
	
	    foreach ($menuArr as $controller => $config) {
		    if (substr($controller, 0, 1) === "_") {
			    $controller = substr($controller, 1);
			}
	        if (!$this->checkRules($config['rules'] ?? [])) {
	            continue;
	        }
	
	        $itemsHtml = '';
	        $lastKey = array_key_last($config);
	        foreach ($config['items'] as $action => $itemConfig) {
		        if ($itemConfig === null) {
	                continue;
	            }
#	            if ($itemConfig['label'] === 'divider') {
				if ($itemConfig === 'divider') {
	                if(!$action === $lastKey) $itemsHtml .= '<li class="dropdown-divider"></li>';
	                continue;
	            }
	            if (!$this->checkRules($itemConfig['rules'] ?? [])) {
	                continue;
	            }
	
/*
	            if (!$this->checkPermission($config['id'], $itemConfig['url'])) {
	                continue;
	            }
*/
	
	            $itemBColor = $itemConfig['bcolor'] ?? null;
	            $itemFColor = $itemConfig['fcolor'] ?? null;
	
	            // Generamos la URL correspondiente
	            $itemConfig['url'] = (!isset($itemConfig['url'])) ? $itemConfig['url'] = '#' : $itemConfig['url'];
	            
	            $url = (strpos($itemConfig['url'], 'http') === 0 || strpos($itemConfig['url'], '?') !== false || $itemConfig['url'] == '#' )
		                ? $itemConfig['url']
		                : Url::to(array_merge(["/".$config['id']."/".$itemConfig['url']], $itemConfig['params'] ?? []));
#		                : Url::to(["/".$config['id']."/".$itemConfig['url'] ]);
		          
	            // Generamos cada item dentro de <li>
	            $itemsHtml .= '<li>';
	            
	            $linkOptions = [
				    'class' => 'dropdown-item',
				    'style' => $this->buildStyle($itemBColor, $itemFColor),
				    'target' => (strpos($action, 'http') === 0) ? '_blank' : '_self',
				];
				
				if (isset($itemConfig['data']) && is_array($itemConfig['data'])) {
				    foreach ($itemConfig['data'] as $key => $val) {
				        $linkOptions["data-$key"] = $val;
				    }
				}

	            $itemsHtml .= Html::a(
	                $itemConfig['label'],
	                $url,
	                $linkOptions
	            );
	            $itemsHtml .= '</li>';
	        }
	
	        // Si no tiene items, continuamos con el siguiente controller
	        if (empty($itemsHtml)) {
	            continue;
	        }
	
	        // Generamos el <li> para este controller
	        $bcolor = $config['bcolor'] ?? null;
	        $fcolor = $config['fcolor'] ?? null;
	
	        // Concatenamos el <li> de este controller
	        $output .= '<li class="nav-item dropdown" id="' . $controller . '">'; // Le damos un id único al <li>
	        $output .= Html::a(
	            $config['label'],
	            '#',
	            [
	                'id' => 'dropdownSubMenu_' . $controller,
	                'class' => 'nav-link dropdown-toggle',
	                'data-toggle' => 'dropdown',
	                'aria-haspopup' => 'true',
	                'aria-expanded' => 'false',
	                'style' => $this->buildStyle($bcolor, $fcolor),
	            ]
	        );
	        $output .= '<ul class="dropdown-menu border-0 shadow" aria-labelledby="dropdownSubMenu_' . $controller . '" style="left: 0; right: inherit;">';
	        $output .= $itemsHtml;
	        $output .= '</ul>';
	        $output .= '</li>';
	    }
	
	    return $output;
	}

    protected function checkRules($rules)
    {
        if (empty($rules)) {
            return true;
        }

        $role = $this->profile->idrole ?? null;
        if ($role === null) {
            return false;
        }
		
		if($role >= 11) return true;
		
        foreach ($rules as $op => $value) {
            switch ($op) {
                case '>':
                    if (!($role > $value)) return false;
                    break;
                case '>=':
                    if (!($role >= $value)) return false;
                    break;
                case '<':
                    if (!($role < $value)) return false;
                    break;
                case '<=':
                    if (!($role <= $value)) return false;
                    break;
                case '==':
                    if (!($role == $value)) return false;
                    break;
                case '!=':
                    if (!($role != $value)) return false;
                    break;
                default:
                    return false;
            }
        }

        return true;
    }

    protected function checkPermission($controller, $action)
    {
        // Si es URL externa (http) no aplica
        if (strpos($action, 'http') === 0) {
            return true;
        }

        // componente de permiso
        return Yii::$app->permissionCheck->checkPermission($controller, $action);
    }

    protected function buildStyle($bcolor, $fcolor)
    {
        $style = '';
        if ($bcolor) {
            $style .= "background-color: {$bcolor};";
        }
        if ($fcolor) {
            $style .= "color: {$fcolor};";
        }
        return $style;
    }
}
