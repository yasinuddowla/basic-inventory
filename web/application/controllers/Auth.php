<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->nameSpace = 'auth';
    }
    function login()
    {
        $this->loadTopNav = false;
        $data['mainView'] = 'login';
        $this->load->view('layouts/main', $data);
    }
    function register()
    {
        $this->loadTopNav = false;
        $data['mainView'] = 'register';
        $this->load->view('layouts/main', $data);
    }
}
