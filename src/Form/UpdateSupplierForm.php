<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Validation\Validator;

class UpdateSupplierForm extends Form {

    /**
     * Build Validator
     * 
     * @param Validator $validator
     * @return Validator object
     */
    protected function _buildValidator(Validator $validator) {
        return $validator
                        ->allowEmpty('email')
                        ->add('email', 'validFormat', [
                            'rule' => 'email',
                            'message' => __('MESSAGE_INVALID_EMAIL_FORMAT')
                        ])
                        ->notEmpty('name', __('MESSAGE_REQUIRED_NAME'))
        ;
    }

}
