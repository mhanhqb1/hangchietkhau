<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Validation\Validator;

class LoginForm extends Form {

    /**
     * Build Validator
     * 
     * @param Validator $validator
     * @return Validator object
     */
    protected function _buildValidator(Validator $validator) {
        return $validator
            ->notEmpty('account', __('MESSAGE_REQUIRED_LOGIN_ID'))
            ->notEmpty('password', __('MESSAGE_REQUIRED_LOGIN_PASSWORD'))
        ;
    }

}
