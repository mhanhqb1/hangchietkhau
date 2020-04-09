<?php

/**
 * API's Url
 */
use Cake\Core\Configure;

Configure::write('API.Timeout', 60);
Configure::write('API.secretKey', 'lyonabeauty');
Configure::write('API.rewriteUrl', array());

Configure::write('API.url_admins_login', 'admins/login');
Configure::write('API.url_admins_updateprofile', 'admins/updateprofile');

Configure::write('API.url_companies_addupdate', 'companies/addupdate');
Configure::write('API.url_companies_detail', 'companies/detail');

Configure::write('API.url_banners_list', 'banners/list');
Configure::write('API.url_banners_addupdate', 'banners/addupdate');
Configure::write('API.url_banners_detail', 'banners/detail');

Configure::write('API.url_products_list', 'products/list');
Configure::write('API.url_products_addupdate', 'products/addupdate');
Configure::write('API.url_products_detail', 'products/detail');
Configure::write('API.url_products_all', 'products/all');

Configure::write('API.url_posts_list', 'posts/list');
Configure::write('API.url_posts_addupdate', 'posts/addupdate');
Configure::write('API.url_posts_detail', 'posts/detail');
Configure::write('API.url_posts_all', 'posts/all');

Configure::write('API.url_customers_list', 'customers/list');
Configure::write('API.url_customers_addupdate', 'customers/addupdate');
Configure::write('API.url_customers_detail', 'customers/detail');
Configure::write('API.url_customers_all', 'customers/all');

Configure::write('API.url_cates_list', 'cates/list');
Configure::write('API.url_cates_addupdate', 'cates/addupdate');
Configure::write('API.url_cates_detail', 'cates/detail');
Configure::write('API.url_cates_all', 'cates/all');

Configure::write('API.url_reports_general', 'reports/general');

Configure::write('API.url_orders_list', 'orders/list');
Configure::write('API.url_orders_detail', 'orders/detail');

Configure::write('API.url_pages_addupdate', 'pages/addupdate');
Configure::write('API.url_pages_detail', 'pages/detail');

Configure::write('API.url_contacts_list', 'contacts/list');