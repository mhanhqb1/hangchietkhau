<?php
use App\Lib\Api;
use Cake\Core\Configure;

$this->doGeneralAction();
$pageSize = Configure::read('Config.PageSize');

// Create breadcrumb
$pageTitle = __('LABEL_ORDER_LIST');
$this->Breadcrumb->setTitle($pageTitle)
        ->add(array(
            'name' => $pageTitle,
        ));

// Create search form
$dataSearch = array(
    'disable' => 0, 
    'limit' => $pageSize
);
$this->SearchForm
        ->setAttribute('type', 'get')
        ->setData($dataSearch)
        ->addElement(array(
            'id' => 'name',
            'label' => __('LABEL_NAME')
        ))
        ->addElement(array(
            'id' => 'phone',
            'label' => __('LABEL_TEL')
        ))
        ->addElement(array(
            'id' => 'limit',
            'label' => __('LABEL_LIMIT'),
            'options' => Configure::read('Config.searchPageSize'),
        ))
        ->addElement(array(
            'type' => 'submit',
            'value' => __('LABEL_SEARCH'),
            'class' => 'btn btn-primary',
        ));

$param = $this->getParams(array(
    'limit' => $pageSize,
    'disable' => 0
));

$result = Api::call(Configure::read('API.url_orders_list'), $param);
$total = !empty($result['total']) ? $result['total'] : 0;
$data = !empty($result['data']) ? $result['data'] : array();

// Show data
$this->SimpleTable
        ->setDataset($data)
        ->addColumn(array(
            'id' => 'item',
            'name' => 'items[]',
            'type' => 'checkbox',
            'value' => '{id}',
            'width' => 20,
        ))
        ->addColumn(array(
            'id' => 'id',
            'title' => __('LABEL_ID'),
            'type' => 'link',
            'href' => $this->BASE_URL . '/' . $this->controller . '/detail/{id}',
            'empty' => '',
            'width' => 50,
        ))
        ->addColumn(array(
            'id' => 'name',
            'title' => __('LABEL_NAME'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'address',
            'title' => __('LABEL_ADDRESS'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'phone',
            'title' => __('LABEL_TEL'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'total_price',
            'title' => __('LABEL_ORDER_TOTAL'),
            'type' => 'currency',
            'width' => 120,
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'created',
            'type' => 'dateonly',
            'title' => __('LABEL_CREATED'),
            'width' => 100,
            'empty' => '',
        ))
        ->addColumn(array(
            'type' => 'link',
            'title' => __('LABEL_DETAIL'),
            'href' => $this->BASE_URL . '/' . $this->controller . '/detail/{id}',
            'button' => true,
            'width' => 50,
        ))
        ->addColumn(array(
            'id' => 'disable',
            'type' => 'checkbox',
            'title' => __('LABEL_DELETE'),
            'toggle' => true,
            'toggle-onstyle' => "primary",
            'toggle-offstyle' => "danger",
            'toggle-options' => array(
                "data-on" => __("LABEL_ENABLE"),
                "data-off" => __("LABEL_DELETE"),
            ),
            'rules' => array(
                '0' => '',
                '1' => 'checked'
            ),
            'empty' => 0,
            'width' => 50,
        ));

$this->set('pageTitle', $pageTitle);
$this->set('total', $total);
$this->set('param', $param);
$this->set('limit', $param['limit']);
$this->set('data', $data);
