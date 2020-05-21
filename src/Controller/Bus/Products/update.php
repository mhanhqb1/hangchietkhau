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

$cateParam = array();
$cates = $this->showCategories(Api::call(Configure::read('API.url_cates_all'), $cateParam));
$cates = $this->Common->arrayKeyValue($this->_cateTemp, 'id', 'name');

$suppliers = $this->Common->arrayKeyValue(
    Api::call(Configure::read('API.url_suppliers_all'), array()), 
    'id', 
    'name'
);

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
        'id' => 'qty',
        'label' => __('QTY'),
        'required' => true,
    ))
    ->addElement(array(
        'id' => 'cate_id',
        'label' => __('LABEL_CATE'),
        'options' => $cates,
        'empty' => '-',
        'multiple' => 'multiple'
    ))
    ->addElement(array(
        'id' => 'supplier_id',
        'label' => __('LABEL_SUPPLIER'),
        'options' => $suppliers,
        'empty' => '-',
    ))
    ->addElement(array(
        'id' => 'image',
        'label' => __('LABEL_IMAGE').'',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'image_2',
        'label' => __('LABEL_IMAGE').' 2',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'image_3',
        'label' => __('LABEL_IMAGE').' 3',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'image_4',
        'label' => __('LABEL_IMAGE').' 4',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'image_5',
        'label' => __('LABEL_IMAGE').' 5',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'admin_price',
        'label' => __('LABEL_ADMIN_PRICE'),
    ))
    ->addElement(array(
        'id' => 'wholesale_price',
        'label' => __('LABEL_WHOLESALE_PRICE'),
    ))
    ->addElement(array(
        'id' => 'discount',
        'label' => __('LABEL_DISCOUNT'),
    ))
    ->addElement(array(
        'id' => 'discount_unit',
        'label' => __('LABEL_DISCOUNT_UNIT'),
        'options' => array(
            '0' => '%',
            '1' => 'Tiền mặt'
        )
    ))
    ->addElement(array(
        'id' => 'root_price',
        'label' => __('LABEL_PRICE'),
    ))
    // ADD supplier id
    ->addElement(array(
        'id' => 'source_url',
        'label' => __('LABEL_SOURCE_URL'),
    ))
    ->addElement(array(
        'id' => 'source_name',
        'label' => __('LABEL_SOURCE_NAME'),
    ))
    ->addElement(array(
        'id' => 'attributes',
        'label' => __('LABEL_ATTRIBUTES'),
        'type' => 'editor'
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
        'id' => 'aff_url',
        'label' => __('Aff URL')
    ))
    ->addElement(array(
        'id' => 'aff_news_url',
        'label' => __('Aff news url (Ten:::link enter)'),
        'type' => 'textarea'
    ))
    ->addElement(array(
        'id' => 'source_pid',
        'label' => __('Source ID'),
        'type' => 'text'
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
        if (!empty($data['image_2']['name'])) {
            $filetype = $data['image_2']['type'];
            $filename = $data['image_2']['name'];
            $filedata = $data['image_2']['tmp_name'];
            $data['image_2'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image_3']['name'])) {
            $filetype = $data['image_3']['type'];
            $filename = $data['image_3']['name'];
            $filedata = $data['image_3']['tmp_name'];
            $data['image_3'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image_4']['name'])) {
            $filetype = $data['image_4']['type'];
            $filename = $data['image_4']['name'];
            $filedata = $data['image_4']['tmp_name'];
            $data['image_4'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['image_5']['name'])) {
            $filetype = $data['image_5']['type'];
            $filename = $data['image_5']['name'];
            $filedata = $data['image_5']['tmp_name'];
            $data['image_5'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['cate_id'])) {
            $data['cate_id'] = implode(',', $data['cate_id']);
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