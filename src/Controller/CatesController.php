<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Cates page
 */
class CatesController extends AppController {
    
    /**
     * Cates page
     */
    public function index() {
        include ('Bus/Cates/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Cates/update.php');
    }
}
