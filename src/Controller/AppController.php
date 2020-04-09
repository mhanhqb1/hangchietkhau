<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Routing\Router;
use App\Lib\Log\AppLog;
use App\Lib\Api;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /** @var object $AppUI Session infomation of user logged. */
    public $AppUI = null;
    
    /** @var object $controller Controller name. */
    public $controller = null;

    /** @var object $action Action name. */
    public $action = null;
    
    public $current_url = '';
    public $BASE_URL = '';
    public $BASE_URL_FRONT = '';
    
    public $_cateTemp = array();

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie', [
            'expires' => Configure::read('Config.CookieExpires'),
            'httpOnly' => true
        ]);
        $this->loadComponent('Common');
        $this->loadComponent('Breadcrumb');
        $this->loadComponent('SimpleForm');
        $this->loadComponent('SearchForm');
        $this->loadComponent('UpdateForm');
        $this->loadComponent('SimpleTable');
        $this->loadComponent('Auth', array(
            'loginRedirect' => false,
            'logoutRedirect' => false,
            'loginAction' => array(
                'controller' => 'login',
                'action' => 'index',
                'plugin' => null
            ),
            'sessionKey' => 'Auth.HNKSenpai'
        ));
        
        // set session ckeditor
        $this->request->session()->write('ckeditor', Configure::read('Config.CKeditor'));
    }
    
    /**
     * Before filter event
     * @param Event $event
     */
    public function beforeFilter(Event $event) {
        // Redirect https
        if (Configure::read('Config.HTTPS') === true) {
            // ロードバランサへHTTPSでアクセスされた場合
            if (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && 443 == $_SERVER['HTTP_X_FORWARDED_PORT']) {
                // ベースURLをHTTPSに書き直す
                Router::fullbaseUrl('https://' . $_SERVER['HTTP_HOST']);
            }
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") {
                return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
            } elseif (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 80) {
                return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
            }
        }
        parent::beforeFilter($event);
        
        $this->controller = strtolower($this->request->params['controller']);
        $this->action = strtolower($this->request->params['action']);
        $this->current_url = Router::url($this->here, true);
        $this->BASE_URL = Router::fullBaseUrl() . USE_SUB_DIRECTORY;
        $this->BASE_URL_FRONT = Configure::read('Front.Host');
        
        // Redirect Auth
        if ($this->isAuthorized()) {
            if ($this->controller == 'login' && $this->action == 'index') {
                return $this->redirect('/');
            }
        }
        
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        parent::beforeRender($event);
        
        // Breadcrumb
        if (!empty($this->Breadcrumb) && !empty($this->Breadcrumb->get())) {
            $this->set('breadcrumbTitle', $this->Breadcrumb->getTitle());
            $this->set('breadcrumb', $this->Breadcrumb->get());
        }
        
        // Form / Table
        if (!empty($this->SearchForm) && !empty($this->SearchForm->get())) {
            $this->set('searchForm', $this->SearchForm->get());
        }
        if (!empty($this->UpdateForm) && !empty($this->UpdateForm->get())) {
            $this->set('updateForm', $this->UpdateForm->get());
        }
        if (!empty($this->SimpleTable) && !empty($this->SimpleTable->get())) {
            $this->set('table', $this->SimpleTable->get());
        }
        
        // Auth
        if (isset($this->Auth) && $this->isAuthorized()) {
            $this->set('AppUI', $this->Auth->user());
        }
        
        // Set common param
        $this->set('controller', $this->controller);
        $this->set('action', $this->action);
        $this->set('current_url', $this->current_url);
        $this->set('BASE_URL', $this->BASE_URL);
        $this->set('BASE_URL_FRONT', $this->BASE_URL_FRONT);
        $this->set('url', $this->request->url);
        $this->set('referer', Controller::referer());

        // Set default layout
        $this->setLayout();
        
        // Check to use common view
        $templatePath = $this->viewBuilder()->templatePath();
        $viewName = $this->action . '.ctp';
        $viewPath = APP . 'Template' . DS . $templatePath . DS . $viewName;
        $commonViewPath = APP . 'Template' . DS . 'Common' . DS . $viewName;
        if (!file_exists($viewPath) && file_exists($commonViewPath)) {
            $this->viewBuilder()->templatePath('Common');
        }
    }
    
    /**
     * Commont function check user is Authorized..
     * 
     * 
     * @param object $user Session user logged.
     * @return boolean  If true is authorize, and false is unauthorize.
     */
    public function isAuthorized($user = null) {
        if (!isset($this->Auth)) {
            return false;
        }
        if (empty($user)) {
            $user = $this->Auth->user();
        }
        if (!empty($user)) {
            $this->AppUI = $user;
            return true;
        }
        return false;
    }

    /**
     * Commont function to get params of actions in controller.
     * 
     * @param array $default List parameter name. Default is array().
     * @return array
     */
    public function getParams($default = array()) {
        $params = $this->request->query;
        if (!empty($default)) {
            foreach ($default as $paramName => $paramValue) {
                if (!isset($params[$paramName])) {
                    $params[$paramName] = $paramValue;
                }
            }
        }
        return $params;
    }
    
    /**
     * Commont function set layout for view.
     */
    public function setLayout() {
        if ($this->controller == 'login' || $this->controller == 'infos') {
            $this->viewBuilder()->layout('empty');
        } else if ($this->controller == 'ajax') {
            $this->viewBuilder()->layout('ajax');
        } else {
            $this->viewBuilder()->layout('vinashop');
        }
    }
    
    /**
     * Commont function creater message notification.
     * 
     * @return object
     */
    public function doGeneralAction() {
        $data = $this->request->data;
        if ($this->request->is('post')) {
            if (!empty($data['actionId'])) {
                $data['items'] = array($data['actionId']);
            }
            if (!empty($data['action']) && !empty($data['items'])) {
                $action = $data['action'];
                $param['id'] = implode(',', $data['items']);
                switch ($action) {
                    case 'enable':
                    case 'disable':
                        $param['disable'] = ($data['action'] == 'disable' ? 1 : 0);
                        $_controller = $this->request->params['controller'];
                        if (in_array($_controller, array('postcates', 'Productcates'))) {
                            $_controller = 'cates';
                        }
                        Api::call("{$_controller}/disable", $param);
                        $error = Api::getError();
                        if ($error) {
                            AppLog::warning("Can not update", __METHOD__, $data);
                            $this->Flash->error(__('MESSAGE_CANNOT_UPDATE'));
                        } else {
                            $this->Flash->success(__('MESSAGE_UPDATE_SUCCESSFULLY'));
                        }
                        break;
                    default:
                        break;
                }
                return $this->redirect($this->request->here(false));
            }
        }
    }
    
    /**
     * Crop image
     * 
     * @param string $mime_type
     * @param string $image_path
     * @param int $x
     * @param int $y
     * @param int $w
     * @param int $h
     */
    public function crop_image($mime_type, $image_path, $x, $y, $w, $h) {
        $mime_type = strtolower($mime_type);
        
        if ($mime_type == 'image/png') {
            // Convert PNG
            $img_r = imagecreatefrompng($image_path);
            $dst_r = ImageCreateTrueColor($w, $h);
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $w, $h, $w, $h);
            imagepng($dst_r, $image_path);
        } else if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg') {
            // convert JPEG
            $img_r = imagecreatefromjpeg($image_path);
            $dst_r = ImageCreateTrueColor($w, $h);
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $w, $h, $w, $h);
            imagejpeg($dst_r, $image_path, 90);
        } else {
            // Not support
        }
    }
    
    /**
     * Crop image from base64
     * 
     * @param string $base64
     * @param string $image_path
     * @param int $x
     * @param int $y
     * @param int $w
     * @param int $h
     * @return boolean
     */
    public function crop_image_from_base64($base64, &$image_path, $x, $y, $w, $h, &$mime_type = '', &$ext = '') {
        list($base64_type, $base64_data) = explode(';', $base64);
        $mime_type = strtolower(str_replace('data:', '', $base64_type));
        list(, $data) = explode(',', $base64_data);
        
        if ($mime_type == 'image/png' || $mime_type == 'image/jpeg' || $mime_type == 'image/jpg') {
            $img_r = imagecreatefromstring(base64_decode($data));
            $dst_r = ImageCreateTrueColor($w, $h);
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $w, $h, $w, $h);
            
            if ($mime_type == 'image/png') {
                $ext = 'png';
                $image_path = $image_path . '.' . $ext;
                return imagepng($dst_r, $image_path);
            } else {
                $ext = 'jpg';
                $image_path = $image_path . '.' . $ext;
                return imagejpeg($dst_r, $image_path, 90);
            }
        }
        return false;
    }
    
    /**
     * Create Curl file upload from base64 string
     * @param string $base64
     * @param string $type
     * @param string $name
     * @param string $file_path
     * @return boolean|\CurlFile
     */
    public function create_file_upload_from_base64($base64, $type, $name, $file_path) {
        try {
            list(, $base64_data) = explode(';', $base64);
            list(, $data) = explode(',', $base64_data);
            
            file_put_contents($file_path, base64_decode($data));
            return new \CurlFile($file_path, $type, $name);
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Get mime type from url
     * 
     * @param string $url
     * @return string
     */
    public function get_mime_type_from_url($url, &$ext = '') {
        $typeString = '';
        $typeInt = exif_imagetype($url);
        switch ($typeInt) {
            case IMAGETYPE_GIF:
                $typeString = 'image/gif';
                $ext = 'gif';
                break;
            case IMAGETYPE_JPEG:
                $typeString = 'image/jpeg';
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $typeString = 'image/png';
                $ext = 'png';
                break;
            default:
                $typeString = '';
                $ext = '';
        }
        return $typeString;
    }
    
    /**
     * Get base64 data from URL
     * 
     * @param string $url
     * @return string | boolean
     */
    public function get_base64_from_url($url) {
        $base64 = false;
        $content = file_get_contents($url);
        if ($content !== false) {
            $base64 = 'data:' . $this->get_mime_type_from_url($url) . ';base64,' . base64_encode($content);
        }
        return $base64;
    }
    
    /**
     * Show categories
     * 
     * @param array
     * @return array
     */
    public function showCategories($categories, $parentid = 0, $char = '')
    {
        if (empty($categories)) {
            return '';
        }
        foreach ($categories as $key => $item) {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parentid) {
                // Xóa chuyên mục đã lặp
                $item['name'] = $char.$item['name'];
                $this->_cateTemp[] = $item;
                unset($categories[$key]);

                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                $this->showCategories($categories, $item['id'], $char . '|---');
            }
        }
    }
    
}
