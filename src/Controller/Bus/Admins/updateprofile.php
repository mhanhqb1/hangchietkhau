<?php

use App\Form\UpdateAdminForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Create breadcrumb
$pageTitle = __('LABEL_UPDATE_PROFILE');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'name' => $pageTitle,
    ));

$data = $this->AppUI;
// Create Update form 
$form = new UpdateAdminForm();
$this->UpdateForm->reset()
    ->setModel($form)
    ->setData($data)
    ->setAttribute('autocomplete', 'off')
    ->addElement(array(
        'id' => 'id',
        'type' => 'hidden',
        'label' => __('id'),
    ))
    ->addElement(array(
        'id' => 'name',
        'label' => __('LABEL_NAME'),
        'required' => true,
        'readonly' => true
    ))
    ->addElement(array(
        'id' => 'email',
        'label' => __('LABEL_EMAIL'),
        'required' => true,
        'readonly' => true
    ))
    ->addElement(array(
        'id' => 'avatar',
        'label' => __('LABEL_AVATAR'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'new_pass',
        'label' => __('Mật khẩu mới'),
        'type' => 'password'
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('LABEL_SAVE'),
        'class' => 'btn btn-primary',
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('LABEL_CANCEL'),
        'class' => 'btn',
        'onclick' => "return back();"
    ));

// Valdate and update
if ($this->request->is('post')) {
    // Trim data
    $data = $this->request->data();
    foreach ($data as $key => $value) {
        if (is_scalar($value)) {
            $data[$key] = trim($value);
        }
    }
    // Validation
    if ($form->validate($data)) {
        if (!empty($data['avatar']['name'])) {
            $filetype = $data['avatar']['type'];
            $filename = $data['avatar']['name'];
            $filedata = $data['avatar']['tmp_name'];
            $data['avatar'] = new CurlFile($filedata, $filetype, $filename);
        }
        // Call API to Login
        $admin = array();
        $admin = Api::call(Configure::read('API.url_admins_updateprofile'), $data);
        if (!empty($admin) && !Api::getError()) {
            // Update auth
            $admin['display_name'] = !empty($admin['name']) ? $admin['name'] : $admin['email'];
            if (empty($admin['avatar'])) {
                $admin['avatar'] = $this->BASE_URL . '/img/' . Configure::read('default_avatar');
            }
            $this->Auth->setUser($admin);
            $this->AppUI = $admin;
            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            return $this->redirect("{$this->BASE_URL}/{$this->controller}/updateprofile");
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}