<?php
use App\Lib\Api;
use Cake\Core\Configure;

$this->doGeneralAction();
$pageSize = Configure::read('Config.PageSize');

// Create breadcrumb
$pageTitle = __('LABEL_PRODUCT_LIST');
$this->Breadcrumb->setTitle($pageTitle)
        ->add(array(
            'name' => $pageTitle,
        ));

// Create search form
$dataSearch = array(
    'disable' => 0, 
    'limit' => $pageSize
);
$cateParam = array(
    'type' => 0
);
$cates = $this->showCategories(Api::call(Configure::read('API.url_cates_all'), $cateParam));
$cates = $this->Common->arrayKeyValue($this->_cateTemp, 'id', 'name');
$this->SearchForm
        ->setAttribute('type', 'get')
        ->setData($dataSearch)
        ->addElement(array(
            'id' => 'name',
            'label' => __('LABEL_NAME')
        ))
        ->addElement(array(
            'id' => 'cate_id',
            'label' => __('LABEL_CATE'),
            'options' => $cates,
            'empty' => 'All'
        ))
        ->addElement(array(
            'id' => 'limit',
            'label' => __('LABEL_LIMIT'),
            'options' => Configure::read('Config.searchPageSize'),
        ))
        ->addElement(array(
            'id' => 'disable',
            'label' => __('LABEL_STATUS'),
            'options' => Configure::read('Config.searchStatus'),
            'empty' => 0
        ))
        ->addElement(array(
            'type' => 'submit',
            'value' => __('LABEL_SEARCH'),
            'class' => 'btn btn-primary',
        ));

$param = $this->getParams(array(
    'limit' => $pageSize
));

$result = Api::call(Configure::read('API.url_products_list'), $param);
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
            'id' => 'image',
            'title' => __('LABEL_AVATAR'),
            'type' => 'image',
            'src' => '{image}',
            'width' => 110,
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'name',
            'title' => __('LABEL_NAME'),
            'type' => 'link',
            'href' => $this->BASE_URL . '/' . $this->controller . '/update/{id}',
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'qty',
            'title' => __('Qty'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'admin_income',
            'title' => __('LABEL_ADMIN_INCOME'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'wholesale_income',
            'title' => __('LABEL_WHOLESALE_INCOME'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'price',
            'title' => __('LABEL_PRICE'),
            'empty' => ''
        ))
        ->addColumn(array(
            'type' => 'link',
            'title' => __('LABEL_EDIT'),
            'href' => $this->BASE_URL . '/' . $this->controller . '/update/{id}',
            'button' => true,
            'width' => 50,
        ))
        ->addButton(array(
            'type' => 'submit',
            'value' => __('LABEL_ADD_NEW'),
            'class' => 'btn btn-success btn-addnew',
        ));
if (!empty($param['disable'])) {
    $this->SimpleTable->addButton(array(
            'type' => 'submit',
            'value' => __('LABEL_ENABLE'),
            'class' => 'btn asds btn-primary btn-enable',
        ));
} else {
    $this->SimpleTable->addButton(array(
            'type' => 'submit',
            'value' => __('LABEL_DELETE'),
            'class' => 'btn btn-danger btn-disable',
        ));
} 

$this->set('pageTitle', $pageTitle);
$this->set('total', $total);
$this->set('param', $param);
$this->set('limit', $param['limit']);
$this->set('data', $data);
