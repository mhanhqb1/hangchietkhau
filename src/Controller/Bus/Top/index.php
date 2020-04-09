<?php
use App\Lib\Api;
use Cake\Core\Configure;

// Create breadcrumb
$pageTitle = __('LABEL_DASHBOARD');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'name' => $pageTitle,
    ));

$param = array();
$data = Api::call(Configure::read('API.url_reports_general'), $param);

$this->set(compact(
    'data'
));