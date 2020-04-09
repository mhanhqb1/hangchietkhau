<?php

namespace App\Controller\Component;

/**
 * 
 * Parent form for search form and update form
 * @package Controller
 * @created 2014-11-27 
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class SimpleFormComponent extends AppComponent {

    /** @var form Object $_model */
    protected $_model = null;

    /** @var array $_data Form data */
    protected $_data = array();

    /** @var array $_attributes Default attributes */
    protected $_attributes = array(
        'role' => 'form',
        'type' => 'post',
        'enctype' => 'multipart/form-data',
    );
    
    // https://holt59.github.io/cakephp3-bootstrap-helpers/
    protected $_templates = array(
        'button' => '<button{{attrs}}>{{text}}</button>',
        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
        'checkboxFormGroup' => '{{label}}',
        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
        'checkboxContainer' => '{{h_checkboxContainer_start}}<div class="checkbox {{required}}">{{content}}</div>{{h_checkboxContainer_end}}',
        'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
        'error' => '<span class="help-block error-message{{h_errorClass}}">{{content}}</span>',
        'errorList' => '<ul>{{content}}</ul>',
        'errorItem' => '<li>{{text}}</li>',
        'file' => '<input type="file" name="{{name}}" {{attrs}}>',
        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'formStart' => '<form{{attrs}}>',
        'formEnd' => '</form>',
        'formGroup' => '{{label}}{{h_formGroup_start}}{{prepend}}{{input}}{{append}}{{h_formGroup_end}}',
        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
        'input' => '<input type="{{type}}" name="{{name}}" class="form-control{{attrs.class}}" {{attrs}} />',
        'inputSubmit' => '<input type="{{type}}"{{attrs}}>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}{{after}}</div>',
        'inputContainerError' => '<div class="form-group has-error {{type}}{{required}}">{{content}}{{error}}</div>',
        'label' => '<label class="{{s_labelClass}}{{h_labelClass}}{{attrs.class}}" {{attrs}}>{{text}}</label>',
        'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
        'legend' => '<legend>{{text}}</legend>',
        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
        'select' => '<select name="{{name}}" class="form-control{{attrs.class}}" {{attrs}}>{{content}}</select>',
        'selectMultiple' => '<select name="{{name}}[]" multiple="multiple" class="form-control{{attrs.class}}" {{attrs}}>{{content}}</select>',
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
        'radioWrapper' => '<div class="radio">{{label}}</div>',
        'radioContainer' => '{{h_radioContainer_start}}<div class="form-group">{{content}}</div>{{h_radioContainer_end}}',
        'textarea' => '<textarea name="{{name}}" class="form-control{{attrs.class}}" {{attrs}}>{{value}}</textarea>',
        'submitContainer' => '<div class="form-group">{{h_submitContainer_start}}{{content}}{{h_submitContainer_end}}</div>',
    );

    /** @var array $_form Form information */
    protected $_form = array();

    /**
     * Set model object
     *
     * @author KienNH
     * @param Object $model Name
     * @return self
     */
    public function setModel($model) {
        $this->_model = $model;
        return $this;
    }

    /**
     * Get model object
     *
     * @author KienNH
     * @return string Model name
     */
    public function getModel() {
        return $this->_model;
    }

    /**
     * Set form data
     *
     * @author thailvn
     * @param array $data Data to set to form
     * @return self
     */
    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    /**
     * Get form data
     *
     * @author thailvn
     * @return array Form data
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * Set attribute
     *
     * @author thailvn
     * @param string $name Attribute name
     * @param string $value Attribute value
     * @param boolean $inputDefaults If true set inputDefaults else set normal
     * @return self
     */
    public function setAttribute($name, $value, $inputDefaults = false) {
        if ($inputDefaults == false) {
            $this->_attributes[$name] = $value;
        } else {
            $this->_attributes['inputDefaults'][$name] = $value;
        }
        return $this;
    }

    /**
     * Get list attribute
     *
     * @author thailvn
     * @return array List attributes
     */
    public function getAttributes() {
        return $this->_attributes;
    }

    /**
     * Add a element to form
     *
     * @author thailvn
     * @param array $item Element information
     * @return self
     */
    public function addElement($item) {
        $request = $this->request;
        $data = $this->getData();
        if ($request->is('get') && !empty($request->query)) {
            $data = array_merge($data, $request->query);
        }
        if ($request->is('post') && isset($request->data)) {
            foreach ($request->data as $key => $value) {
                if (is_scalar($value)) {
                    $data[$key] = $value;
                }
            }
        }
        if (isset($item['id']) && isset($data[$item['id']])) {
            $item['value'] = $data[$item['id']];
        }
        if (isset($item['id']) && isset($item['type']) && $item['type'] != 'hidden' && preg_match('/_id$/', $item['id'])) {
            $item['id'] = str_replace('_id', '_customid', $item['id']);
        }
        if (!empty($item['calendar']) && !empty($item['value']) && is_numeric($item['value'])) {
            $item['value'] = date('Y-m-d', $item['value']);
        }
        if (!empty($item['calendar_full']) && !empty($item['value']) && is_numeric($item['value'])) {
            $item['value'] = date('Y-m-d H:i', $item['value']);
        }
        $this->_form[] = $item;
        return $this;
    }

    /**
     * Get information of a form
     *
     * @author thailvn
     * @return array Form information
     */
    public function get() {
        return array(
            'model' => $this->_model,
            'attributes' => $this->_attributes,
            'elements' => $this->_form,
            'templates' => $this->_templates
        );
    }

    /**
     * Reset a form (for create muiltiple forms on a page)
     *
     * @author thailvn
     * @return self
     */
    public function reset() {
        $this->_form = array();
        return $this;
    }

    /**
     * Remove a element
     *
     * @author thailvn
     * @param string $id Element ID
     * @return self
     */
    public function removeElement($id) {
        foreach ($this->_form as $i => $element) {
            if (isset($element['id']) && $element['id'] == $id) {
                unset($this->_form[$i]);
            }
        }
        return $this;
    }

}
