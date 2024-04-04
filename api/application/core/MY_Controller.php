
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $userId = null;
    public $agentId = null;
    public $requiredAuth = true;
    public $postData = [];

    function __construct($options = [])
    {
        parent::__construct();
        $this->configure($options);
    }
    public function configure($options)
    {
        if (isset($options['requiredAuth']))
            $this->requiredAuth = $options['requiredAuth'];
        $this->postData = getRawInput();
        if ($this->requiredAuth)
            $this->authorizeUser();
    }
    public function authorizeUser()
    {
        $this->userId = $this->authModel->validateToken();
    }
}
