<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $data['mainView'] = 'inventory/index';
        $this->load->view('layouts/main', $data);
    }
    function details($invId)
    {
        $data['inventoryId'] = $invId;
        $data['mainView'] = 'inventory/items/index';
        $this->load->view('layouts/main', $data);
    }
}
