<?php require_once("../../resources/config.php"); ?>
<?php
session_start(); 
session_destroy();
header("Location: ../../public");
?>