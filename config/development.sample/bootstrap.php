<?php
/* 
 * Development's Config
 */

use Cake\Core\Configure;

define('USE_SUB_DIRECTORY', '');

Configure::write('API.Host', 'http://api.conlatatca.localhost/');
Configure::write('Config.HTTPS', false);

Configure::write('Config.CKeditor', array(
    'basel_dir'=>'path/upload/',
    'basel_url'=>'http://img.conlatatca.localhost/'
));
