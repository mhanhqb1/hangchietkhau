<?php

namespace App\View\Helper;

use Cake\View\Helper;
use App\Controller\Component\CommonComponent;
use Cake\Controller\ComponentRegistry;

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package View.Helper
 */
class AppHelper extends Helper {

    /** @var string $controller Controller name */
    public $controller;
    
    /**
     * Load a controller
     *     
     * @author thailvn   
     * @param string $name Controller name    
     * @return Object Controller 
     */
    protected function loadController($name = null) {
        if (is_null($name)) {
            $name = $this->params['controller'];
        }
        $className = ucfirst($name) . 'Controller';
        list($plugin, $className) = pluginSplit($className, true);
        App::import('Controller', $name);
        $cont = new $className;
        $cont->constructClasses();
        $cont->request = $this->request;
        return $cont;
    }

    /**
     * Create Common component for helper
     *     
     * @author thailvn        
     * @return Object Common component 
     */
    public static function getCommonComponent() {
        return new CommonComponent(new ComponentRegistry());
    }

}
