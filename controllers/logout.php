<?php
require_once('../header.inc.php');
try {	
	//Si no esta logueado se va
	$_SESSION['USUARIO'] = null;
	session_destroy();
	//echo "Se limpio la session";
	header('location: /controllers/login.php');
	exit();    
} catch (Exception $e) {

}
include(ROOT_PATH . '/views/Default.php');
?>