<?php

namespace App\Controller\Component;

/**
 * 
 * Create table for a page
 * @package Controller
 * @created 2014-11-27 
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class SimpleTableComponent extends AppComponent {

    /** @var string $__modelName Model name */
    private $__modelName = null;

    /** @var array $__columns List columns */
    private $__columns = array();

    /** @var array $__dataset Dataset */
    private $__dataset = array();

    /** @var array $__buttons List Button  */
    private $__buttons = array();

    /** @var array $__hiddens List Hidden */
    private $__hiddens = array();

    /** @var array $__mergeColumns List merged columns */
    private $__mergeColumns = array();

    /**
     * Create Disabled html
     *    
     * @author thailvn
     * @param string $txt Text
     * @return string Html
     */
    public function disabledTemplate($txt = 'Disabled') {
        return "<span class=\"label label-danger\">" . __($txt) . "</span>";
    }

    /**
     * Create Enabled html
     *
     * @author thailvn
     * @param string $txt Text
     * @return string Html
     */
    public function enabledTemplate($txt = 'Enabled') {
        return "<span class=\"label label-primary\">" . __($txt) . "</span>";
    }

    /**
     * Create No html
     *
     * @author thailvn
     * @param string $txt Text
     * @return string Html
     */
    public function noTemplate($txt = 'No') {
        return "<span class=\"label label-danger\">" . __($txt) . "</span>";
    }

    /**
     * Create Yes html
     *    
     * @author thailvn
     * @param string $txt Text
     * @return string Html
     */
    public function yesTemplate($txt = 'Yes') {
        return "<span class=\"label label-primary\">" . __($txt) . "</span>";
    }

    /**
     * Create Button html
     *
     * @author thailvn
     * @param string $txt Text
     * @return string Html
     */
    public function buttonTemplate($txt) {
        return "<span class=\"label label-primary\">" . __($txt) . "</span>";
    }

    /**
     * Remove a column
     *    
     * @author thailvn
     * @param string $id Column ID
     * @return self
     */
    public function removeColumn($id) {
        foreach ($this->__columns as $i => $column) {
            if (isset($column['id']) && $column['id'] == $id) {
                unset($this->__columns[$i]);
            }
        }
        return $this;
    }

    /**
     * Update column attribute
     *     
     * @author thailvn
     * @param string $id Column ID
     * @param string $attr Attribute name
     * @param string|array $value Attribute value
     * @return self
     */
    public function updateColumnAttr($id, $attr, $value = '') {
        foreach ($this->__columns as $i => $column) {
            if (isset($column['id']) && $column['id'] == $id) {
                $this->__columns[$i][$attr] = $value;
            }
        }
        return $this;
    }

    /**
     * Add a column
     *     
     * @author thailvn
     * @param array $column Column information 
     * @return self
     */
    public function addColumn($column = array()) {
        $this->__columns[] = $column;
        return $this;
    }

    /**
     * Get columns
     *    
     * @author thailvn    
     * @return array List columns 
     */
    public function getColumns() {
        return $this->__columns;
    }

    /**
     * Set model name
     *    
     * @author thailvn    
     * @param string $modelName Name
     * @return array Model name
     */
    public function setModelName($modelName = null) {
        $this->__modelName = $modelName;
        return $this;
    }

    /**
     * Get model name
     *   
     * @author thailvn        
     * @return string Model name 
     */
    public function getModelName() {
        return $this->__modelName;
    }

    /**
     * Set dataset
     *    
     * @author thailvn    
     * @param array $dataset Dataset     
     * @return self
     */
    public function setDataset($dataset = array()) {
        $this->__dataset = $dataset;
        return $this;
    }

    /**
     * Get dataset
     *    
     * @author thailvn       
     * @return array Dataset 
     */
    public function getDataset() {
        return $this->__dataset;
    }

    /**
     * Add a action button (add new, save, cancel , ...)
     *    
     * @author thailvn     
     * @param array $button Button information   
     * @return self
     */
    public function addButton($button = array()) {
        $this->__buttons[] = $button;
        return $this;
    }

    /**
     * Remove a action button
     *    
     * @author thailvn     
     * @param string $id Button ID
     * @return self
     */
    public function removeButton($id) {
        foreach ($this->__buttons as $i => $button) {
            if (isset($button['id']) && $button['id'] == $id) {
                unset($this->__buttons[$i]);
            }
        }
        return $this;
    }

    /**
     * Get list buttons
     *     
     * @author thailvn        
     * @return array
     */
    public function getButtons() {
        return $this->__buttons;
    }

    /**
     * Add a hidden input
     *    
     * @author thailvn     
     * @param array $hidden Hidden input information
     * @return self
     */
    public function addHidden($hidden = array()) {
        $this->__hiddens[] = $hidden;
        return $this;
    }

    /**
     * Get hidden inputs
     *     
     * @author thailvn         
     * @return array
     */
    public function getHiddens() {
        return $this->__hiddens;
    }

    /**
     * Merge columns
     *     
     * @author thailvn   
     * @param array $columns
     * @return self
     */
    public function setMergeColumn($columns = array()) {
        $this->__mergeColumns = $columns;
        return $this;
    }

    /**
     * Get merged columns
     *    
     * @access public
     * @author thailvn         
     * @return array
     */
    public function getMergeColumn() {
        return $this->__mergeColumns;
    }

    /**
     * Get all infos if table
     *   
     * @author thailvn         
     * @return array Information to create table
     */
    public function get() {
        return array(
            'modelName' => $this->__modelName,
            'columns' => $this->__columns,
            'dataset' => $this->__dataset,
            'buttons' => $this->__buttons,
            'hiddens' => $this->__hiddens,
            'merges' => $this->__mergeColumns,
        );
    }

}
