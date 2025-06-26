<?php
    
namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Randomizer extends Component{
    

    public static $chars = '0123456789abcdefghijklmnopqrstuvwxyzabcdef';
    
    /*
     *  Genera una cadena alfanumerica de caraceteres aleatoria.
     *
    /**/
    public static function str($largo, $upper = false, string $prefix = '', string $suffix = '')
    {
        self::$chars .= $upper ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXY0123456789' : '';
        return $prefix . self::generateString($largo) . $suffix;
    }
    
    /*
     *   Genera una cadena alfanumerica de caraceteres lowercase aleatoria y agrega fecha al final.
     *   dode $largo es el tamaño total de la cadena con la fecha incluida (-yymmdd)
    /**/
    public static function strDate($largo, $upper = false, string $prefix = '', string $suffix = '')
    {
	    $largo -= 7;
        self::$chars .= $upper ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXY0123456789' : '';
                
        $result = self::generateString($largo);

        $result .= date('-ymd');
        return $prefix . $result . $suffix;
    }

    /*
     *
     *   Genera una cadena alfanumerica de caraceteres lowercase aleatoria.
     *
    /**/
    public static function symbolUnsafe($largo, $upper = false, string $prefix = '', string $suffix = '')
    {
        self::$chars .= '!~@#$%^&*()+-_';
        self::$chars .= $upper ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXY!~@#$%^&*()+-_' : '';
        
        return $prefix . self::generateString($largo) . $suffix;
    }

    /*
     *
     *   Genera una cadena alfanumerica de caraceteres lowercase aleatoria.
     *
    /**/
    public static function symbolSafe($largo, $upper = false, string $prefix = '', string $suffix = '')
    {
        self::$chars .= '!~-_';
        self::$chars .= $upper ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXY0123456789' : '';
        
        return $prefix . self::generateString($largo) . $suffix;
    }
    
    /*
     *   Generador de strings
    /****************************/
    private static function generateString($largo){

        $result = '';
        for ($i = 0; $i < $largo; $i++) {
            $result .= self::$chars[random_int(0, strlen(self::$chars)-1)];
        }
        return $result;
    }
    
    
}

