<?php
/* 
 * Production's Config
 */

use Cake\Core\Configure;

define('USE_SUB_DIRECTORY', '');

Configure::write('API.Host', 'http://api.hangchietkhau.com/public/');
Configure::write('Config.HTTPS', true);

Configure::write('Config.CKeditor', array(
    'basel_dir'=>'/home/lyonabea/img.hangchietkhau.com/',
    'basel_url'=>'https://img.hangchietkhau.com/'
));
