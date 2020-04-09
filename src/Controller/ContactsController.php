<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Contacts page
 */
class ContactsController extends AppController {
    
    /**
     * Contacts page
     */
    public function index() {
        include ('Bus/Contacts/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Contacts/update.php');
    }
}
