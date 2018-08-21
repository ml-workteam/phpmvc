<?php

namespace App\Controllers;
use \Core\View;

/**
 * Home controller
 */

class Home extends \Core\Controller {
    protected function before(){
        echo "(before)";
        return true;
    }

    protected function after(){
        echo "(after)";
    }
    
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction(){
        //echo 'Hello from the index action in the Home controller';
        /*
        View::render('Home/index.php', [
            'name' => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */
        View::renderTemplate ('Home/index.html', [
            'name' => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }
}