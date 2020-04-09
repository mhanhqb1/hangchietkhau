<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Top page
 */
class TopController extends AppController {
    
    /**
     * Top page
     */
    public function index() {
        include ('Bus/Top/index.php');
    }
}
