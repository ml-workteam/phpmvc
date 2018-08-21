<?php
/* Class Router
*/

namespace Core;

class Router {
    protected $routes = [];

    /** 
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, ets)
     * 
     */
    protected $params = [];

    public function add($route, $params = []){
        //convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // convert variables e/g/ {controller}
        $route = preg_replace ('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // convert variables with custom regular expression e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //add start and end delimeters, and case insensitive flag
        $route = '/^'. $route . '$/i';

        $this->routes[$route] = $params;
    }
    public  function getRoutes() {
        return $this->routes;
    }

    public function match($url){
        /*foreach ($this->routes as $route => $params){
            if($url == $route) {
                $this->params =$params;
                return true;
            }
        } */
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        foreach ($this->routes as $route => $params) {

            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function dispatch($url) {

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if(class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller $controller) not found.";
                }
            } else {
                echo "Controller class $controller not found";
            }

        } else {
            echo 'No route matched.';
        }

    }

    public function getParams() {
        return $this->params;
    }

    /** 
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     * 
     * @param string $string The string to convert
     * 
     * @return string
    */
    protected function convertToStudlyCaps($string) {
        return str_replace(' ', '',ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     * 
     * @param string $string The string to convert
     * 
     * @return string
     */
    private function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Removes Variables from Query String
     * 
     * @param string Query to clear
     * 
     * @return string
     */
    private function removeQueryStringVariables($url){
        if ($url != '') {
            $parts = explode ('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get namespcae
     */
    protected function getNamespace() {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}