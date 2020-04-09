<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Posts page
 */
class PostsController extends AppController {
    
    /**
     * Posts page
     */
    public function index() {
        include ('Bus/Posts/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Posts/update.php');
    }
}
