<?php

/* 
 * Ajax process
 */

namespace App\Controller;

class AjaxController extends AppController {
    
    public function initialize() {
        parent::initialize();
       // $this->autoRender = false;
    }
    
    /**
     * Disable action
     */
    public function disable() {
        $this->autoRender = false;
        include ('Bus/Ajax/disable.php');
    }
    
    /**
     * Order add action
     */
    public function orderadd() {
        $this->autoRender = false;
        include ('Bus/Ajax/orderadd.php');
    }
}
