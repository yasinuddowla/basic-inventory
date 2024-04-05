<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    function __construct($options = [])
    {
        parent::__construct();
        $this->loadTopNav = true;
        $this->systemName = 'InvenT';
    }
}
