<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['register']['post'] = 'auth/register';
$route['login']['post'] = 'auth/login';
$route['logout']['post'] = 'auth/logout';
$route['refresh']['post'] = 'auth/refreshToken';

$route['user']['get'] = 'user/profile';
$route['user']['patch'] = 'user/update';

$route['inventory']['post'] = 'inventory/add';
$route['inventory']['patch'] = 'inventory/update';
$route['inventory']['delete'] = 'inventory/delete';
$route['inventory']['get'] = 'inventory/index';
$route['inventory/(:num)']['get'] = 'inventory/details/$1';

$route['inventory/item']['post'] = 'item/add';
$route['inventory/item']['patch'] = 'item/update';
$route['inventory/item']['delete'] = 'item/delete';
$route['inventory/item']['get'] = 'item/index';
$route['inventory/item/(:num)']['get'] = 'item/details';

// Default
$route['default_controller'] = 'home';
$route['404_override'] = 'My_error/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['(.*)'] = 'My_error/error_404';
