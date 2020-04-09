<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Validation\Validator;

class UpdatePostForm extends Form {

    /**
     * Build Validator
     * 
     * @param Validator $validator
     * @return Validator object
     */
    protected function _buildValidator(Validator $validator) {
        return $validator
                        ->notEmpty('name', __('MESSAGE_REQUIRED_NAME'))
        ;
    }

}
