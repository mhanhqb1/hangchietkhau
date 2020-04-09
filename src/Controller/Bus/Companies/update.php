<?php

use App\Form\UpdateCustomerForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = null;
$data = Api::call(Configure::read('API.url_companies_detail'), array());

$pageTitle = __('LABEL_COMPANY_UPDATE');

// Create breadcrumb
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdateCustomerForm();
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
    ))
    ->addElement(array(
        'id' => 'logo',
        'label' => __('LABEL_LOGO'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'tel',
        'label' => __('LABEL_TEL'),
    ))
    ->addElement(array(
        'id' => 'address',
        'label' => __('LABEL_ADDRESS'),
    ))
    ->addElement(array(
        'id' => 'email',
        'label' => __('LABEL_EMAIL'),
    ))
    ->addElement(array(
        'id' => 'facebook',
        'label' => __('LABEL_FACEBOOK'),
    ))
    ->addElement(array(
        'id' => 'twitter',
        'label' => __('LABEL_TWITTER'),
    ))
    ->addElement(array(
        'id' => 'instagram',
        'label' => __('LABEL_INSTAGRAM'),
    ))
    ->addElement(array(
        'id' => 'google_plus',
        'label' => __('LABEL_GOOGLE_PLUS'),
    ))
    ->addElement(array(
        'id' => 'youtube',
        'label' => __('LABEL_YOUTUBE'),
    ))
    ->addElement(array(
        'id' => 'zalo',
        'label' => __('LABEL_ZALO'),
    ))
    ->addElement(array(
        'id' => 'seo_image',
        'label' => __('LABEL_SEO_IMAGE'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'seo_description',
        'label' => __('LABEL_SEO_DESCRIPTION'),
        'type' => 'textarea',
    ))
    ->addElement(array(
        'id' => 'seo_keyword',
        'label' => __('LABEL_SEO_KEYWORD'),
        'type' => 'textarea',
    ))
    ->addElement(array(
        'id' => 'script_header',
        'label' => __('LABEL_SCRIPT_HEADER'),
        'type' => 'textarea',
        'rows' => 7
    ))
    ->addElement(array(
        'id' => 'script_body',
        'label' => __('LABEL_SCRIPT_BODY'),
        'type' => 'textarea',
        'rows' => 7
    ))
    ->addElement(array(
        'id' => 'script_footer',
        'label' => __('LABEL_SCRIPT_FOOTER'),
        'type' => 'textarea',
        'rows' => 7
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
        if (!empty($data['logo']['name'])) {
            $filetype = $data['logo']['type'];
            $filename = $data['logo']['name'];
            $filedata = $data['logo']['tmp_name'];
            $data['logo'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['seo_image']['name'])) {
            $filetype = $data['seo_image']['type'];
            $filename = $data['seo_image']['name'];
            $filedata = $data['seo_image']['tmp_name'];
            $data['seo_image'] = new CurlFile($filedata, $filetype, $filename);
        }
        // Call API
        $id = Api::call(Configure::read('API.url_companies_addupdate'), $data);
        if (!empty($id) && !Api::getError()) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            return $this->redirect("{$this->BASE_URL}/{$this->controller}/update");
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}