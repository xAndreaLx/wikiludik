<?php
class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null ;
            
    public function __construct() {
        $this->_db = DB::getInstance() ;
    }
    
    public function check($source, $items = array()) {  //on met un array par défaut afin de ne pas avoir d'erreurs sur le foreach
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = trim($source[$item]) ; 
                $item = escape($item) ; 
                
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$rules['name']} est requis") ;
                //    $this->addError("{$item} is required") ;
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min' :
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$rules['name']} doit être au minimum de {$rule_value} caractères") ;
                            }
                            break;
                        case 'max' :
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$rules['name']} doit être au maximum de {$rule_value} caractères") ;
                            }
                            break ;
                        case 'matches' :
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rules['name']} n'est pas identique au {$rules['matchesName']}") ;
                            }
                            break ;
                        case 'unique':
                                $check = $this->_db->get($rule_value, array($item, '=', $value)) ;
                                if ($check->count()) {
                                    $this->addError("{$rules['name']} existe déjà") ; 
                                }
                            break ;
                    }
                }
            }
        }
        
        if(empty($this->_errors)) {
            $this->_passed = true ; 
        }
        
        return $this ;
    }
    
    private function addError($error) {
        $this->_errors[] = $error ;
    }
    
    public function errors() {
        return $this->_errors ;
    }
    
    public function passed() {
        return $this->_passed ; 
    }
}
?>