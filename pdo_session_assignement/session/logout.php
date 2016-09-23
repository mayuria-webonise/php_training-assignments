<?php
session_start();
function logout(){
    session_unset();
    session_destroy();
    header("location:index.php");
}

logout();
?>