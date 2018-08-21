<?php
/**
 * TWIG
 */
require_once '../vendor/autoload.php';

//$loader = new Twig_Loader_Filesystem(dirname(__DIR__).'/App/Views');
//$twig = new Twig_Environment($loader, array());

/**
 * Autoloader
 */
spl_autoload_register(function($class) {
    $root = dirname(__DIR__); //get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

$router = new Core\Router();

//echo get_class($router);

$router->add('',['controller'=>'Home', 'action'=>'index']);
$router->add('posts', ['controller'=>'Posts', 'action'=>'index']);
//$router->add('posts/new', ['controller'=>'Posts','action'=>'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' =>'Admin']);

// echo '<pre>';
// var_dump ($router->getRoutes());
// echo '</pre>';

/* $url = $_SERVER['QUERY_STRING'];
if ($router->match($url)){
    echo '<pre>';
    var_dump ($router->getParams());
    echo htmlspecialchars(print_r($router->getRoutes(), true));
    echo '</pre>';
} else {
    echo "No route found for URL $url";

}
*/

$router->dispatch($_SERVER['QUERY_STRING']);