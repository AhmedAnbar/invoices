<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";

$user = new User();

$user->logout();
Session::flash('fmsg', "<div class=\"text-center\">you'r logged out<br /> please login again or try another user</div>");
Redirect::to('login.php');


?>