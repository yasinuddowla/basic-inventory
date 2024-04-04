<?php
function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function arrayHasValues($arr = [], $indices = '')
{
    $keys = explode('|', $indices);
    foreach ($keys as $key)
        if (empty($arr[$key]))
            return false;
    return true;
}
function getRawInput()
{
    $handler = fopen('php://input', 'r');
    return json_decode(stream_get_contents($handler), true);
}
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function lastQuery()
{
    $CI = &get_instance();
    return $CI->db->last_query();
}

function validateFormData($arr)
{
    if (!is_array($arr)) return false;
    foreach ($arr  as $key => $val) {
        $arr[$key] = validateInput($val);
    }
    return $arr;
}

function makeRequest($url, $data, $options = [])
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $options['headers'] ?? []);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $options['method'] ?? 'POST');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

    $resultdata = curl_exec($curl);
    curl_close($curl);
    return json_decode($resultdata, true);
}
function pp($arr)
{
    echo '<pre style="overflow: unset">';
    print_r($arr);
    echo '</pre>';
}
function ppd($arr)
{
    pp($arr);
    die();
}
function setSessionValue($var, $value = '')
{
    $user = config_item('session_user');
    if (!isset($_SESSION[$user])) {
        $_SESSION[$user] = [];
    }
    if (is_array($var)) {
        $_SESSION[$user] = array_merge($_SESSION[$user], $var);
        return;
    }
    $_SESSION[$user][$var] = $value;
    return;
}
function getSessionValue($var)
{
    $sess = $_SESSION[config_item('session_user')] ?? '';
    return $sess[$var] ?? null;
}
function resetSession()
{
    unset($_SESSION[config_item('session_user')]);
}
function unsetSessionValue($var)
{
    unset($_SESSION[config_item('session_user')][$var]);
}
function getHeader($name)
{
    $header = null;
    if (isset($_SERVER[$name])) {
        $header = trim($_SERVER[$name]);
    } else if (isset($_SERVER['HTTP_' . strtoupper($name)])) { //Nginx or fast CGI
        $header = trim($_SERVER['HTTP_' . strtoupper($name)]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders[$name])) {
            $header = trim($requestHeaders[$name]);
        }
    }
    return $header;
}
function getBearerToken()
{
    $headers = getHeader('Authorization');
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    throwError(AUTHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
}
