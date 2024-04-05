<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('uploader');
        $this->load->model('item_model', 'itemModel');
    }
    function index()
    {
        $data = $this->itemModel->get(['user_id' => $this->userId]);
        returnResponse($data);
    }
    function add($inventoryId)
    {
        if (!arrayHasValues($this->postData, 'name|quantity|image'))
            throwError(BAD_REQUEST, 'Invalid data');

        if (!empty($this->postData['image'])) {
            $imageFileName = $this->uploader->uploadBase64($this->postData['image']);
            if (!$imageFileName) {
                throwError(BAD_REQUEST, 'Invalid image');
            }
        }
        if ($itemId = $this->itemModel->insert([
            'inventory_id' => $inventoryId,
            'name' => $this->postData['name'],
            'description' => $this->postData['description'],
            'image' => $imageFileName,
            'quantity' => $this->postData['quantity'],
        ])) {
            $data = $this->itemModel->get(['id' => $itemId], true);
            returnResponse($data, 'Item added to inventory.');
        }
        throwError(ITEM_INSERT_FAILURE, 'Something went wrong. Please try again later.');
    }
    function update($itemId)
    {
        $item = $this->itemModel->get([
            'id' => $itemId,
            'user_id' => $this->userId,
        ], true);
        if (!$item) {
            throwError(ITEM_NOT_FOUND, 'Item not found.');
        }

        if (!empty($this->postData['name']))
            $data['name'] = $this->postData['name'];
        if (!empty($this->postData['description']))
            $data['description'] = $this->postData['description'];
        if (!empty($this->postData['quantity']))
            $data['quantity'] = $this->postData['quantity'];
        if (!empty($this->postData['image'])) {
            $imageFileName = $this->uploader->uploadBase64($this->postData['image']);
            if (!$imageFileName) {
                throwError(BAD_REQUEST, 'Invalid image');
            }
            $data['image'] = $imageFileName;
        }
        if ($this->itemModel->updateById($itemId, $data)) {
            $data = $this->itemModel->get(['id' => $itemId], true);
            returnResponse($data, 'Item updated.');
        }
        throwError(ITEM_UPDATE_FAILURE, 'Something went wrong. Please try again later.');
    }
    function details($itemId)
    {
        $data = $this->itemModel->get([
            'user_id' => $this->userId,
            'id' => $itemId,
        ], true);
        returnResponse($data);
    }
    function delete($itemId)
    {
        $this->itemModel->delete($itemId);
        returnResponse(null, 'Item deleted.');
    }
}
