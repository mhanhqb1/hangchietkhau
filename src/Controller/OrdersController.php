<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Orders page
 */
class OrdersController extends AppController {
    
    /**
     * Orders page
     */
    public function index() {
        include ('Bus/Orders/index.php');
    }
    
    /**
     * Orders add/update
     */
    public function update($id = '') {
        include ('Bus/Orders/update.php');
    }
    
    /**
     * Orders add/update
     */
    public function add($id = '') {
        include ('Bus/Orders/add.php');
    }
    
    /**
     * Orders detail
     */
    public function detail($id = '') {
        include ('Bus/Orders/detail.php');
    }
}
