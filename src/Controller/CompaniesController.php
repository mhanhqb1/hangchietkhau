<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Companies page
 */
class CompaniesController extends AppController {
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Companies/update.php');
    }
}
