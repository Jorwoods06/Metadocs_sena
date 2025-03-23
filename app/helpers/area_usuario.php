<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $area= $_SESSION['area'];
    $id_usuario = $_SESSION['id_log'];


}

?>