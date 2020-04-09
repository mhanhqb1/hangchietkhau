<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Cates page
 */
class PostcatesController extends AppController {
    
    /**
     * Cates page
     */
    public function index() {
        include ('Bus/Postcates/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Postcates/update.php');
    }
}
