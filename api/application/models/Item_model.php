<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'item';
    }

    function get($filters = [], $returnRow = false)
    {
        $filters['with_inventory_details'] = $filters['with_inventory_details'] ?? true;
        if (isset($filters['id'])) {
            $this->db->where('it.id', $filters['id']);
        }
        if (isset($filters['inventory_id'])) {
            $this->db->where('it.inventory_id', $filters['inventory_id']);
        }
        if (isset($filters['user_id'])) {
            $this->db->where('in.user_id', $filters['user_id']);
        }
        if ($filters['with_inventory_details']) {
            $this->db->select("in.name inventory_name, in.description inventory_description");
        }
        if ($returnRow) $this->db->limit(1);
        $data = $this->db->select("it.*")
            ->join('inventory in', 'in.id = it.inventory_id')
            ->get("{$this->table} it")->result_array();
        if ($returnRow) return !$data ? null : $data[0];
        return $data;
    }
}
