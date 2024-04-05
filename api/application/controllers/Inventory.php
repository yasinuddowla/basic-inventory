<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventoryModel');
        $this->load->model('item_model', 'itemModel');
    }
    function index()
    {
        $data = $this->inventoryModel->get(['user_id' => $this->userId]);
        returnResponse($data);
    }
    function add()
    {
        if (!arrayHasValues($this->postData, 'name'))
            throwError(BAD_REQUEST, 'Invalid data');

        if ($this->inventoryModel->nameExists($this->postData['name'])) {
            throwError(ITEM_INSERT_FAILURE, 'Inventory already exists.');
        }

        if ($inventoryId = $this->inventoryModel->insert([
            'user_id' => $this->userId,
            'name' => $this->postData['name'],
            'description' => $this->postData['description'],
        ])) {
            $data = $this->inventoryModel->get(['id' => $inventoryId], true);
            returnResponse($data, 'Inventory added.');
        }
        throwError(ITEM_INSERT_FAILURE, 'Something went wrong. Please try again later.');
    }
    function update($inventoryId)
    {
        if (!arrayHasValues($this->postData, 'name'))
            throwError(BAD_REQUEST, 'Invalid data');

        if (!$inventory = $this->inventoryModel->get([
            'user_id' => $this->userId,
            'inventory_id' => $inventoryId
        ], true)) {
            throwError(ITEM_NOT_FOUND, 'Inventory not found.');
        }
        if ($this->inventoryModel->nameExists($this->postData['name'], $inventoryId)) {
            throwError(ITEM_INSERT_FAILURE, 'Inventory already exists.');
        }
        if ($this->inventoryModel->updateById($inventoryId, [
            'name' => $this->postData['name'],
            'description' => $this->postData['description'],
        ])) {
            $data = $this->inventoryModel->get(['id' => $inventoryId], true);
            returnResponse($data, 'Inventory updated.');
        }
        throwError(ITEM_UPDATE_FAILURE, 'Something went wrong. Please try again later.');
    }
    function details($inventoryId)
    {
        $data = $this->inventoryModel->get([
            'user_id' => $this->userId,
            'inventory_id' => $inventoryId,
        ], true);
        if ($data) {
            $data['items'] = $this->itemModel->get([
                'user_id' => $this->userId,
                'inventory_id' => $inventoryId,
                'with_inventory_details' => false,
            ]);
        }
        returnResponse($data);
    }
    function delete($inventoryId)
    {
        $data = $this->inventoryModel->delete($inventoryId);
        returnResponse(null, 'Inventory deleted.');
    }
}
