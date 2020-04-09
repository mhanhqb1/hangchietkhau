<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Cates page
 */
class ProductcatesController extends AppController {
    
    /**
     * Cates page
     */
    public function index() {
        include ('Bus/Productcates/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Productcates/update.php');
    }
}
