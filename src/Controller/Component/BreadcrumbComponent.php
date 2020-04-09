<?php

namespace App\Controller\Component;

/**
 * 
 * Render breadcrumb for application
 * @package Controller
 * @created 2014-11-24 
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class BreadcrumbComponent extends AppComponent {

    /** @var string $__title Title */
    private $__title = '';

    /** @var array $__breadcrumbs Information to create breadcrumb  */
    private $__breadcrumbs = array();

    /**
     * Set Title
     *     
     * @author thailvn
     * @param string $title Page title
     * @return self
     */
    public function setTitle($title) {
        $this->__title = $title;
        return $this;
    }

    /**
     * Get Title
     *     
     * @author thailvn     
     * @return string title
     */
    public function getTitle() {
        return $this->__title;
    }

    /**
     * Add a breadcrumb
     *    
     * @author thailvn
     * @param array $item Breadcrumb information
     * @return self
     */
    public function add($item) {
        $this->__breadcrumbs[] = $item;
        return $this;
    }

    /**
     * Get breadcrumbs
     *   
     * @author thailvn     
     * @return array Breadcrumb information
     */
    public function get() {
        return $this->__breadcrumbs;
    }

}
