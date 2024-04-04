<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(['requiredAuth' => false]);
    }
    public function login()
    {
        if (!arrayHasValues($this->postData, 'email|password'))
            throwError(BAD_REQUEST, 'Invalid data');
        if (!$user = $this->userModel->get(['email' => $this->postData['email']], true)) {
            throwError(UNAUTHORIZED);
        }
        $this->authModel->createUserToken($user['id']);
    }
    public function refreshToken()
    {
        if (empty($this->postData['refresh_token'])) {
            throwError(BAD_REQUEST, 'Refresh token not found');
        }
        $this->authModel->refreshUserToken($this->postData['refresh_token']);
    }
    public function logout()
    {
        $this->authorizeUser();
        if (!$this->authModel->clearTokens($this->userId)) {
            throwError(ITEM_UPDATE_FAILURE, 'Logout failed.');
        }
        returnResponse(null, 'Logged out.');
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
