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
$status = array(
    0 => '<span class="label label-info">Chờ duyệt</span>',
    1 => '<span class="label label-success">Đã duyệt</span>',
    2 => '<span class="label label-warning">Trùng đơn</span>',
    3 => '<span class="label label-danger">Hủy</span>',
    4 => '<span class="label label-primary">Tạm duyệt</span>'
);
$products = $this->Common->arrayKeyValue(Api::call(Configure::read('API.url_products_all')), 'id', 'name');
$this->SearchForm
        ->setAttribute('type', 'get')
        ->setData($dataSearch)
        ->addElement(array(
            'id' => 'product_id',
            'label' => __('LABEL_PRODUCT'),
            'options' => $products,
            'empty' => '-'
        ))
        ->addElement(array(
            'id' => 'status',
            'label' => __('Status'),
            'options' => $status,
            'empty' => '-'
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
            'id' => 'product_image',
            'title' => __('LABEL_AVATAR'),
            'type' => 'image',
            'src' => '{product_image}',
            'width' => 110,
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'product_name',
            'title' => __('LABEL_TEL'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'user_id',
            'title' => __('User ID'),
            'empty' => '-'
        ))
        ->addColumn(array(
            'id' => 'price',
            'title' => __('LABEL_PRICE'),
            'type' => 'currency',
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'wholesale_income',
            'title' => __('LABEL_WHOLESALE_INCOME'),
            'type' => 'currency',
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'admin_income',
            'title' => __('LABEL_ADMIN_INCOME'),
            'type' => 'currency',
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'source_payout',
            'title' => __('Source Payout'),
            'type' => 'currency',
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'status',
            'title' => __('Status'),
            'rules' => $status
        ))
        ->addColumn(array(
            'id' => 'created',
            'type' => 'dateonly',
            'title' => __('LABEL_CREATED'),
            'width' => 100,
            'empty' => '',
        ))
        ->addColumn(array(
            'id' => 'updated',
            'type' => 'dateonly',
            'title' => __('Update'),
            'width' => 100,
            'empty' => '',
        ))
        ->addButton(array(
            'type' => 'submit',
            'value' => __('Duyệt Đơn'),
            'class' => 'btn btn-success btn-order-success',
        ));

$this->set('pageTitle', $pageTitle);
$this->set('total', $total);
$this->set('param', $param);
$this->set('limit', $param['limit']);
$this->set('data', $data);
