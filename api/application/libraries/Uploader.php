<?php defined('BASEPATH') or exit('No direct script access allowed');

class Uploader
{
    public $root = '';

    public $fileName = '';
    public $uploadDir = 'uploads/';
    public $uploadPath = '';

    function getLocalFileUrl($field, $config = [])
    {
        $config['allowed_types'] = '*';
        $file = $this->uploadFile($field, $config);
        if (isset($file['error'])) {
            return false;
        }
        return base_url() . $this->uploadPath . $file['file_name'];
    }
    function uploadFile($field, $config = [])
    {
        $this->uploadPath = $this->root . $this->uploadDir;
        $config['encrypt_name'] = true;
        $config['upload_path'] = $this->uploadPath;
        $CI = &get_instance();
        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!is_dir($this->uploadPath)) mkdir($this->uploadPath);

        if (!$CI->upload->do_upload($field)) {
            $data['error'] =  $CI->upload->display_errors('', '');
            $data['file_name'] = '';
        } else {
            $data = $CI->upload->data();
            $data['url'] = base_url() . $this->uploadDir . $data['file_name'];
        }
        return $data;
    }
}
