<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Products page
 */
class ProductsController extends AppController {
    
    /**
     * Products page
     */
    public function index() {
        include ('Bus/Products/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Products/update.php');
    }
}
