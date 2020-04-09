<?php

use App\Lib\Api;
use App\Lib\Log\AppLog;

$param = $this->request->data;
$apiUrl = "{$param['controller']}/disable";
$result = Api::call($apiUrl, $param);
if (empty($result) || Api::getError()) {
    AppLog::warning("Can not update", __METHOD__, $param);
    echo __('error');
}