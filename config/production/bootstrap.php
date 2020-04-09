<?php
/* 
 * Production's Config
 */

use Cake\Core\Configure;

define('USE_SUB_DIRECTORY', '');

Configure::write('API.Host', 'http://api.tusachehon.com/public/');
Configure::write('Config.HTTPS', false);

Configure::write('Config.CKeditor', array(
    'basel_dir'=>'/home/lyonabea/img.tusachehon.com/',
    'basel_url'=>'https://img.tusachehon.com/'
));
