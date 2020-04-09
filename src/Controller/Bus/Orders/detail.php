<?php

use App\Form\UpdateProductForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = array();
$pageTitle = __('LABEL_ORDER_DETAIL');
if (!empty($id)) {
    // Edit
    $param['id'] = $id;
    $data = Api::call(Configure::read('API.url_orders_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        AppLog::info("Order unavailable", __METHOD__, $param);
        throw new NotFoundException("Order unavailable", __METHOD__, $param);
    }
} else {
    exit('Error');
}

// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/orders');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_ORDER_LIST'),
    ))
    ->add(array(
        'name' => $pageTitle,
    ));


$this->set('data', $data);