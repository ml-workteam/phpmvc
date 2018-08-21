<?php

namespace Core;

/**
 * Base controller
 */

 abstract class Controller {

    /**
     * parameters from the matched route
     */
    protected $route_params = [];

    public function __call($name, $args) {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() != false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "Method $method not found in controller " . get_class($this);
        }
    } 


    /**
     * class constructor
     * 
     * @param array $route_params Parameters from the route
     * 
     * @return void
     */
    public function __construct($route_params) {
        $this->route_params = $route_params;
    }

    protected function before(){
        return true;
    }

    protected function after() {
        return true;
    }

 }