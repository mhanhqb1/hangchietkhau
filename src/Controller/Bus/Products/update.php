<?php

use App\Form\UpdateProductForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = null;
if (!empty($id)) {
    // Edit
    $param['id'] = $id;
    $data = Api::call(Configure::read('API.url_products_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        AppLog::info("Product unavailable", __METHOD__, $param);
        throw new NotFoundException("Product unavailable", __METHOD__, $param);
    }
    
    $pageTitle = __('LABEL_PRODUCT_UPDATE');
} else {
    // Create new
    $pageTitle = __('LABEL_ADD_NEW');
}

$cateParam = array(
    'type' => 1
);
$cates = $this->showCategories(Api::call(Configure::read('API.url_cates_all'), $cateParam));
$cates = $this->Common->arrayKeyValue($this->_cateTemp, 'id', 'name');

// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/products');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_PRODUCT_LIST'),
    ))
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdateProductForm();
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
        'id' => 'cate_id',
        'label' => __('LABEL_CATE'),
        'options' => $cates,
        'empty' => '-'
    ))
    ->addElement(array(
        'id' => 'image',
        'label' => __('LABEL_IMAGE').'(378x378)',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'image2',
        'label' => __('LABEL_IMAGE').'(378x378)',
        'image' => true,
        'type' => 'file'
    ))
        ->addElement(array(
        'id' => 'image3',
        'label' => __('LABEL_IMAGE').'(378x378)',
        'image' => true,
        'type' => 'file'
    ))
        ->addElement(array(
        'id' => 'image4',
        'label' => __('LABEL_IMAGE').'(378x378)',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'price',
        'label' => __('LABEL_PRICE'),
    ))
    ->addElement(array(
        'id' => 'discount_price',
        'label' => __('LABEL_DISCOUNT_PRICE'),
    ))
    ->addElement(array(
        'id' => 'description',
        'label' => __('LABEL_DESCRIPTION'),
        'type' => 'textarea'
    ))
    ->addElement(array(
        'id' => 'detail',
        'label' => __('LABEL_DETAIL'),
        'type' => 'editor'
    ))
    ->addElement(array(
        'id' => 'is_hot',
        'label' => __('LABEL_IS_HOT'),
        'options' => Configure::read('Config.noYes')
    ))
    ->addElement(array(
        'id' => 'seo_keyword',
        'label' => __('LABEL_SEO_KEYWORD')
    ))
    ->addElement(array(
        'id' => 'seo_description',
        'label' => __('LABEL_SEO_DESCRIPTION'),
        'type' => 'textarea'
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
        if (!empty($data['image']['name'])) {
            $filetype = $data['image']['type'];
            $filename = $data['image']['name'];
            $filedata = $data['image']['tmp_name'];
            $data['image'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image2']['name'])) {
            $filetype = $data['image2']['type'];
            $filename = $data['image2']['name'];
            $filedata = $data['image2']['tmp_name'];
            $data['image2'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image3']['name'])) {
            $filetype = $data['image3']['type'];
            $filename = $data['image3']['name'];
            $filedata = $data['image3']['tmp_name'];
            $data['image3'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image4']['name'])) {
            $filetype = $data['image4']['type'];
            $filename = $data['image4']['name'];
            $filedata = $data['image4']['tmp_name'];
            $data['image4'] = new CurlFile($filedata, $filetype, $filename);
        }
        // Call API
        $id = Api::call(Configure::read('API.url_products_addupdate'), $data);
        if (!empty($id) && !Api::getError()) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            return $this->redirect("{$this->BASE_URL}/{$this->controller}/update/{$id}");
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}