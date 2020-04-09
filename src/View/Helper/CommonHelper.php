<?php

namespace App\View\Helper;

use Cake\Routing\Router;

/**
 * 
 * Some common helper
 * @package View.Helper
 * @created 2014-11-30
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class CommonHelper extends AppHelper {

    /** @var array $helpers Use helpers */
    public $helpers = array('Text', 'Form');

    /**
     * Get thumb image url
     *     
     * @author thailvn
     * @param string $fileName File name
     * @param string $size Thumb size     
     * @return string Thumb image url  
     */
    function thumb($fileName, $size = null, $type = null) {
        return $this->getCommonComponent()->thumb($fileName, $size, $type);
    }

    /**
     * search backwards starting from haystack length characters from the end
     */
    function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    /**
     * search forward starting from end minus needle length characters
     */
    function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    /**
     * Render CKEditor script
     *     
     * @author thailvn
     * @param array $params Options         
     * @return string Html 
     */
    function editor($params = array()) {
        include_once WWW_ROOT . 'ckeditor/ckeditor_custom.php';
        include_once WWW_ROOT . 'ckfinder/ckfinder.php';
        $id = isset($params['id']) ? $params['id'] : '';
        $value = isset($params['value']) ? $params['value'] : '';
        $name = isset($params['name']) ? $params['name'] : '';
        $value = isset($params['value']) ? $params['value'] : '';
        $width = isset($params['width']) ? $params['width'] : 0;
        $height = isset($params['height']) ? $params['height'] : 0;
        $CKEditor = new \CKEditor();
        $CKFinder = new \CKFinder();
        $config = array();
        $config['toolbar'] = array(
            array('Source'),
            array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
            array('CreateDiv'),
            array('Image', 'Smiley', 'Table', 'Link', 'Unlink'),
            array('Format', 'Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'TextColor', 'BGColor')
        );
        $config['height'] = $height;
        $config['width'] = $width;
        //$config['filebrowserImageUploadUrl'] = Router::url('/') . "ckupload.php";	
        //$config['filebrowserImageBrowseUrl'] = Router::url('/') . "ckbrowser.php";	
        $events['instanceReady'] = 'function (ev) {
            alert("Loaded: " + ev.editor.name);
        }';
        $CKEditor->basePath = Router::url('/') . 'ckeditor/';

        /*
          $CKFinder->BasePath = Router::url('/') . 'ckfinder/';
          $CKFinder->BaseUrl = Configure::read('Config.EditorImageUrl');
          $EditorUploadPath = Configure::read('Config.EditorUploadPath');
          if (empty($EditorUploadPath)) {
          $EditorUploadPath = WWW_ROOT . 'ckfinder' . DS . 'userfiles/';
          }
          $CKFinder->BaseDir = $EditorUploadPath;
         * 
         */
        $CKFinder->SetupCKEditorObject($CKEditor);

        $config['filebrowserBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html';
        $config['filebrowserImageBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html?type=Images';
        $config['filebrowserFlashBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html?type=Flash';
        $config['filebrowserUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
        $config['filebrowserImageUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
        $config['filebrowserFlashUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
        $params['type'] = 'textarea';
        $out = $CKEditor->editor($this->Form->input($id, $params), $id, $value, $config, null);
        return $out;
    }

    /**
     * Convert Stock number to Status string
     * 
     * @param int $stock
     * @return string
     */
    public function stockStatus($stock = 0) {
        $stock_status = '';
        if (empty($stock) || $stock <= 0) {
            $stock_status = '×';
        } else if ($stock >= 4) {
            $stock_status = '○';
        } else {
            $stock_status = '△';
        }
        return $stock_status;
    }

    /**
     * Convert vn string
     * 
     * @param int $stock
     * @return string
     */
    public function convertURL($str, $space = false) {
        $str = preg_replace("/(\,|-|\.)/", '', $str);
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace("/", "-", $str);
        if ($space) {
            $str = str_replace(" ", "-", $str);
        }
        return strtolower($str);
    }

}
