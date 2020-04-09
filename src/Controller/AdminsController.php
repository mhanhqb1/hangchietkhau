<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Admins page
 */
class AdminsController extends AppController {
    
    /**
     * Admins page
     */
    public function updateprofile() {
        include ('Bus/Admins/updateprofile.php');
    }
}
