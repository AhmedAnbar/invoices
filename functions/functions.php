<?php
// Secure HTML Input
function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

// Include Scripts From Root Path
function includeScript($path) {
	return include $_SERVER['DOCUMENT_ROOT'] . "/invoices/{$path}";
}

// Path To Root Directory
function root($path) {
	return $_SERVER['DOCUMENT_ROOT'] . "/invoices/{$path}";
}

// absulot path used in links
function linkto($path) {
	echo "/invoices/{$path}";
}

//Print BootStrap Success Message Style
function Success ($message) {
	echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
					<span aria-hidden=\"true\">&times;</span>
					</button>
					{$message}
				</div>" ;
}

//Print BootStrap Danger Message Style
function Danger($message) {
	echo "<div class=\"alert alert-danger alert-dismissible show fade in\" role=\"alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
					<span aria-hidden=\"true\">&times;</span>
					</button>
					{$message}
				</div>" ;
}

$INC_DIR = $_SERVER['DOCUMENT_ROOT'] . "/invoices/includes/";

?>
