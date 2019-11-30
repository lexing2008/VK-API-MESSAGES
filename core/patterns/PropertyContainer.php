<?php

namespace Core\Patterns;

trait PropertyContainer {
    private $properties = array();

    public function set( $property, $value ){
        $this->properties[$property] = $value;
    }
    
    public function get( $property ){
        return $this->properties[$property];
    }
}