<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventoryModel');
        $this->load->model('item_model', 'itemModel');
    }
    public function register()
    {
        if (!arrayHasValues($this->postData, 'email|password'))
            throwError(BAD_REQUEST, 'Invalid data');
        if ($this->userModel->get(['email' => $this->postData['email']], true)) {
            throwError(ITEM_INSERT_FAILURE, 'User already registered.');
        }
        if ($this->userModel->register($this->postData)) {
            returnResponse(null, 'Registration successful.');
        }
        throwError(ITEM_INSERT_FAILURE, 'Something went wrong. Please try again later.');
    }
}
