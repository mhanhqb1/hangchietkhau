<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Customers page
 */
class CustomersController extends AppController {
    
    /**
     * Customers page
     */
    public function index() {
        include ('Bus/Customers/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Customers/update.php');
    }
}
