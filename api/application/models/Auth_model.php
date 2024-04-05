<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends MY_Model
{
	public $expireAt;
	public $issuedAt;

	function __construct()
	{
		parent::__construct();
		$this->load->library('jwt');
		$this->issuedAt = time();
		$this->expireAt = $this->issuedAt + 600; // 10 mins
		$this->table = 'auth';
	}
	public function get($filters = [], $returnRow = false)
	{
		if (isset($filters['id'])) {
			$this->db->where('id', $filters['id']);
		}
		if (isset($filters['user_id'])) {
			$this->db->where('user_id', $filters['user_id']);
		}
		if (isset($filters['refresh_token'])) {
			$this->db->where('refresh_token', $filters['refresh_token']);
		}
		if ($returnRow) $this->db->limit(1);
		$data = $this->db->get("{$this->table}")->result_array();
		if ($returnRow) return !$data ? null : $data[0];
		return $data;
	}
	public function createUserToken($userId)
	{
		$user = $this->userModel->get(['id' => $userId], true);
		$authUser = $this->authModel->get(['user_id' => $userId], true);
		if (!password_verify($this->postData['password'], $authUser['password']))
			throwError(UNAUTHORIZED);
		try {
			$token = $this->issuePersonJWT(['userId' => $userId]);
			$refreshToken = !empty($authUser['refresh_token']) ? $authUser['refresh_token'] :  generateRandomString(256);
			if (!$this->authModel->updateOrInsertToken($userId, [
				'refresh_token' => $refreshToken
			])) {
				throwError(ITEM_INSERT_FAILURE, 'Token record update failure.');
			}
			returnResponse([
				'user_id' => $userId,
				'email' => $user['email'],
				'expires_at' => $this->expireAt,
				'token' => $token,
				'refresh_token' => $refreshToken,
			]);
		} catch (Exception $e) {
			throwError(JWT_PROCESSING_ERROR, $e->getMessage());
		}
	}
	function clearTokens($userId)
	{
		return $this->updateOrInsertToken($userId, [
			'refresh_token' => '',
		]);
	}
	function issuePersonJWT($data)
	{
		try {
			$payload = [
				'iat' => $this->issuedAt,
				'iss' => 'InventoryUser',
				'exp' => $this->expireAt,
				'id' => $data['userId']
			];
			return JWT::encode($payload, JWT_SECRETE_KEY);
		} catch (Exception $e) {
			throwError(JWT_PROCESSING_ERROR, $e->getMessage());
		}
	}
	public function refreshUserToken($refreshToken)
	{
		$auth = $this->get([
			'refresh_token' => $refreshToken
		], true);
		if (!$auth) {
			throwError(UNAUTHORIZED, 'Invalid refresh token.');
		}
		try {
			$token = $this->issuePersonJWT(['userId' => $auth['user_id']]);
			returnResponse([
				'token' => $token,
				'expires_at' => $this->expireAt,
			]);
		} catch (Exception $e) {
			throwError(JWT_PROCESSING_ERROR, $e->getMessage());
		}
	}
	function updateOrInsertToken($userId, $data = [])
	{
		if (!($authUser = $this->get(['user_id' => $userId], true))) {
			return $this->insert([
				'user_id' => $userId,
				'refresh_token' => $data['refresh_token'] ?? ''
			]);
		}
		if (!$this->updateById($authUser['id'], $data)) {
			return false;
		}
		return $authUser['id'];
	}
	public function validateToken()
	{
		try {
			$token = getBearerToken();
			$payload = JWT::decode($token, JWT_SECRETE_KEY, ['HS256']);
			$userId = $payload->id;
			if (
				!$this->userModel->getById($userId)
				|| !$this->get(['user_id' => $userId], true)
				|| !$this->isValidToken($userId, $token)
			) {
				throwError(UNAUTHORIZED);
			}
			return $userId;
			throwError(UNAUTHORIZED);
		} catch (Exception $e) {
			throwError(UNAUTHORIZED, $e->getMessage());
		}
	}
	function isValidToken($userId, $token)
	{
		$authUser = $this->get([
			'user_id' => $userId,
			'token' => $token
		]);
		return $authUser ? true : false;
	}
}
