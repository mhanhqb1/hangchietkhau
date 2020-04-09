<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Validation\Validator;

class UpdateAdminForm extends Form {

    /**
     * Build Validator
     * 
     * @param Validator $validator
     * @return Validator object
     */
    protected function _buildValidator(Validator $validator) {
        return $validator
                        ->notEmpty('account', __('MESSAGE_REQUIRED_LOGIN_ID'))
                        ->notEmpty('email', __('MESSAGE_REQUIRED_EMAIL'))
                        ->add('email', 'validFormat', [
                            'rule' => 'email',
                            'message' => '"MESSAGE_INVALID_EMAIL_FORMAT'
                        ])
                        ->notEmpty('name', __('MESSAGE_REQUIRED_NAME'))
        ;
    }

}
