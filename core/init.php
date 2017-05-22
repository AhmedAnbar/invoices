<?php
// Start php session
session_start();

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => 'Meshoo221',
    'db' => 'invoices'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
  ),
  'server' => array(
  	'name' => 'http://127.0.0.1/invoices/'
  )
);
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoices/functions/functions.php';

spl_autoload_register(function($class) {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/invoices/classes/' . $class . '.php';
});

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('Hash', '=', $hash));
	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->userId);
		$user->login();
	}
} else {
	$user = new User();
}