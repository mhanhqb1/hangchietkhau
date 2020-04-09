<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Suppliers page
 */
class SuppliersController extends AppController {
    
    /**
     * Suppliers page
     */
    public function index() {
        include ('Bus/Suppliers/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Suppliers/update.php');
    }
}
