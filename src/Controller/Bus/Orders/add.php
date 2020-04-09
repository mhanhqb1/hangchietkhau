<?php
use App\Lib\Api;
use Cake\Core\Configure;

$data = array();
$param = $this->getParams(array());
$type = !empty($param['type']) ? $param['type'] : '';
if (!empty($id)) {
    $data = Api::call(Configure::read('API.url_orders_detail'), array(
        'id' => $id
    ));
    $type = !empty($data['type']) ? $data['type'] : '';
}

$pageTitle = __('LABEL_ORDER_SELL');
if ($type == 2) {
    $pageTitle = __('LABEL_ORDER_BUY');
    $customers = Api::call(Configure::read('API.url_suppliers_all'), $param);
} else {
    $customers = Api::call(Configure::read('API.url_customers_all'), $param);
}

$products = Api::call(Configure::read('API.url_products_all'), $param);

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


$this->set(compact(
        'products',
        'customers',
        'data',
        'type'
));