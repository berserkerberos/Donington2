<?php
require_once('../header.inc.php');
if (empty($_SESSION['USUARIO'])) {
    header('location: /controllers/login.php');
}
try {	
	//Controller de inicio	   
} catch (Exception $e) {

}
include(ROOT_PATH . '/views/inicio.php');
?>