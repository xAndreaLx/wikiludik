<?php

class Config {
    public static function get($path = null) {
        if ($path) {
            $config = $GLOBALS['config'] ;
            $path = explode('/', $path) ;
            
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit] ; //on rentre à chaque fois plus "profondement" dans le tableau
                }
            }
            
            return $config ;
        }
        
        return false ;
    }
}


?>