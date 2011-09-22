<?php

class Hook {
    private $hooks = array();
    
    private static $instance = null;
    
    
    public static function instance(){
        if(self::$instance === NULL){
            self::$instance = new Hook();
        }
        return self::$instance;
    }   
    
    public function register($event,$function_name,$param="") {
        if(!isset($this->hooks[$event])){
            $this->hooks[$event] = array();
        } 
        if($param) {
            $this->hooks[$event][$function_name] = $param;
        } else {
            $this->hooks[$event][$function_name] = "";
        
        }
                
    }

    public function trigger($event,$object=NULL) {
        if(!isset($this->hooks[$event])) {
            return array();
        }
        $return = array();
        
        foreach($this->hooks[$event] as $function=>$params) {
            if (strpos($function, '::')){
                                
                // Split the class and method of the rule
                list($class, $method) = explode('::', $function, 2);

                // Use a static method call
                $method = new ReflectionMethod($class, $method);
                $para = array();                    
                if(is_array($params)){
                    if($object) {
                        array_push($para, $object);                 
                    }
                    foreach($params as $param){
                        array_push($para, $param);                  
                    }
                } else {
                    if($object) {
                        array_push($para, $object);                 
                    }                   
                    array_push($para, $params);
                }
                // Call $Class::$method($this[$field], $param, ...) with Reflection
                $return[] = $method->invokeArgs(NULL, $para);


            } else if(strpos($function, '->')){ 
                // Split the class and method of the rule
                list($class, $method) = explode('->', $function, 2);

                // Use a static method call
                $method = new ReflectionMethod($class, $method);

                // Call $Class::$method($this[$field], $param, ...) with Reflection
                $return[] = $method->invoke(new $class, "");
            } else {
                $return[] = call_user_func($function);      
            }
        } 
        
        return $return; 
    }
    
}