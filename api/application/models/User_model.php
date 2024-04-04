<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }

    function get($filters = [], $returnRow = false)
    {
        if (isset($filters['id'])) {
            $this->db->where('id', $filters['id']);
        }
        if (isset($filters['email'])) {
            $this->db->where('email', $filters['email']);
        }
        if ($returnRow) $this->db->limit(1);
        $data = $this->db->get("{$this->table}")->result_array();
        if ($returnRow) return !$data ? null : $data[0];
        return $data;
    }
    function register($data)
    {
        $userId = $this->insert([
            'email' => $data['email'],
        ]);
        return $this->authModel->insert([
            'user_id' => $userId,
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }
}
