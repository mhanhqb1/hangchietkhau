<?php

use App\Form\UpdateCateForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = null;
if (!empty($id)) {
    // Edit
    $param['id'] = $id;
    $data = Api::call(Configure::read('API.url_cates_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        return $this->Flash->error(__('MESSAGE_DATA_NOT_EXIST'));
    }
    
    $pageTitle = __('LABEL_CATE_UPDATE');
} else {
    // Create new
    $pageTitle = __('LABEL_ADD_NEW');
}
$cateParam = array(
    'type' => 1,
    'parent_id' => 0
);
if (!empty($id)) {
    $cateParam['not_id'] = $id;
}
$cates = $this->showCategories(Api::call(Configure::read('API.url_cates_all'), $cateParam));
$cates = $this->Common->arrayKeyValue($this->_cateTemp, 'id', 'name');
// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/productcates');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_CATE_LIST'),
    ))
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdateCateForm();
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
        'id' => 'parent_id',
        'label' => __('LABEL_CATE_PARENT'),
        'options' => $cates,
        'empty' => '-'
    ))
    ->addElement(array(
        'id' => 'position',
        'label' => __('LABEL_POSITION'),
    ))
    ->addElement(array(
        'id' => 'is_homepage',
        'label' => __('LABEL_IS_HOMEPAGE'),
        'options' => Configure::read('Config.noYes')
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
        // Call API
        $data['type'] = 1;
        $id = Api::call(Configure::read('API.url_cates_addupdate'), $data);
        if (!empty($id) && !Api::getError()) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            return $this->redirect("{$this->BASE_URL}/{$this->controller}/update/{$id}");
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}