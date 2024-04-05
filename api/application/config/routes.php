<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['register']['post'] = 'auth/register';
$route['login']['post'] = 'auth/login';
$route['logout']['post'] = 'auth/logout';
$route['refresh']['post'] = 'auth/refreshToken';

$route['user']['get'] = 'user/profile';
$route['user']['patch'] = 'user/update';

$route['inventory']['post'] = 'inventory/add';
$route['inventory']['get'] = 'inventory/index';
$route['inventory/(:num)']['patch'] = 'inventory/update/$1';
$route['inventory/(:num)']['delete'] = 'inventory/delete/$1';
$route['inventory/(:num)']['get'] = 'inventory/details/$1';

$route['inventory/(:num)/items']['post'] = 'item/add/$1';
$route['inventory/items']['get'] = 'item/index';
$route['inventory/items/(:num)']['patch'] = 'item/update/$1';
$route['inventory/items/(:num)']['delete'] = 'item/delete/$1';
$route['inventory/items/(:num)']['get'] = 'item/details/$1';

// Default
$route['default_controller'] = 'home';
$route['404_override'] = 'My_error/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['(.*)'] = 'My_error/error_404';
