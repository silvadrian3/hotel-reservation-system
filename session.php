<?php
session_start();
if(!isset($_SESSION["username"]) && !isset($_SESSION["userpass"])){
    session_destroy();
    header("Location: ../login.php?return=invalid_user");
}

?>
