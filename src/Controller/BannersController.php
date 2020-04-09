<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Banners page
 */
class BannersController extends AppController {
    
    /**
     * Banners page
     */
    public function index() {
        include ('Bus/Banners/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Banners/update.php');
    }
}
