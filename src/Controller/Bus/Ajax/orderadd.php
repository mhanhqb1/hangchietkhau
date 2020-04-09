<?php

use App\Lib\Api;
use App\Lib\Log\AppLog;
use Cake\Core\Configure;

header('Content-Type: application/json');

$param = $this->request->data;
if (!empty($param['product_data']) && is_array($param['product_data'])) {
    $param['product_data'] = json_encode($param['product_data']);
}
$orderId = Api::call(Configure::read('API.url_orders_addupdate'), $param);

$result = array(
    'status' => 'OK',
    'data' => ''
);
if (empty($orderId) || Api::getError()) {
    AppLog::warning("Can not update", __METHOD__, $param);
    $result = array(
        'status' => 'ERROR',
        'data' => ''
    );
} else {
    $result['data'] = $orderId;
}

echo json_encode($result);
exit();