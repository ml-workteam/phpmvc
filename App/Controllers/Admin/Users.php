<?php
namespace App\Controllers\Admin;

class Users extends \Core\Controller {

    protected function before (){
        return true;
    }

    public function indexAction() {
        echo "User admin index";
    }
}