<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * 
 * Parent class of components in Application
 * @package Controller
 * @created 2014-11-24
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class AppComponent extends Component {

    /**
     * Replace id to Custom ID (fix bug of core)
     *    
     * @author thailvn
     * @param string $id ID
     * @return string New Id   
     */
    public function _customId($id = null) {
        if (isset($id) && preg_match('/_id$/', $id)) {
            $id = str_replace('_id', '_customid', $id);
        }
        return $id;
    }

    /**
     * Replace Custom ID to id (fix bug of core)
     *     
     * @author thailvn
     * @param string $id Custom ID
     * @return string New Id   
     */
    public function _id($id = null) {
        if (isset($id) && preg_match('/_customid$/', $id)) {
            $id = str_replace('_customid', '_id', $id);
        }
        return $id;
    }

}
