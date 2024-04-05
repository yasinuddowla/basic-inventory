<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';

$route['default_controller'] = 'home';
$route['404_override'] = 'My_error/error_404';
$route['translate_uri_dashes'] = FALSE;
