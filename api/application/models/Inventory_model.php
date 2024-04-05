<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'inventory';
    }

    function get($filters = [], $returnRow = false)
    {
        if (isset($filters['id'])) {
            $this->db->where('id', $filters['id']);
        }
        if (isset($filters['name'])) {
            $this->db->where('name', $filters['name']);
        }
        if ($returnRow) $this->db->limit(1);
        $data = $this->db->get("{$this->table}")->result_array();
        if ($returnRow) return !$data ? null : $data[0];
        return $data;
    }
    function nameExists($name, $ignoreId = null)
    {
        if (isset($name)) {
            $this->db->where('name', $name);
        }
        if (isset($ignoreId)) {
            $this->db->where('id!=', $ignoreId, null);
        }
        return $this->db->get("{$this->table}")->result_array() ? true : false;
    }
}
