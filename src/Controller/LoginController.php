<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Login page
 */
class LoginController extends AppController {
    
    /**
     * Before filter event
     * @param Event $event
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }
    
    /**
     * Login page
     */
    public function index() {
        include ('Bus/Login/index.php');
    }
    
    /**
     * Logout action
     */
    public function logout() {
        include ('Bus/Login/logout.php');
    }
    
}
