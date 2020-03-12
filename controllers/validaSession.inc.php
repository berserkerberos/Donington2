<?php
try {
  
  //Si no esta logueado se va
  if(empty($_SESSION['USUARIO'])){
    header('location: /controllers/login.php');
    exit();
  }
    
} catch (Exception $e) {

}

?>