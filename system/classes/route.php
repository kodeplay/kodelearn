<?php defined('SYSPATH') or die('No direct script access.');

class Route extends Kohana_Route 
{
    public function matches($uri)
    {
        if ($this->_callback)
        {
            $closure = $this->_callback;
            $params = call_user_func($closure, $uri);

            if ( ! is_array($params))
                return FALSE;
        }
        else
        {
            if ( ! preg_match($this->_route_regex, $uri, $matches))
                return FALSE;

            $params = array();
            foreach ($matches as $key => $value)
            {
                if (is_int($key))
                {
                    // Skip all unnamed keys
                    continue;
                }

                // Set the value for all matched keys
                $params[$key] = $value;
            }

        }

        foreach ($this->_defaults as $key => $value)
        {
            if ( ! isset($params[$key]) OR $params[$key] === '')
            {
                // Set default values for any key that was not matched
                $params[$key] = $value;
            }
        }
        
        if(isset($params['params'])){
            $array = explode('/',$params['params']);
            
            while(count($array) >= 2){
                $key = array_shift($array);
                $value = array_shift($array);
                $params[$key] = $value;
            }
        }
        
        return $params;
    }
    

}
