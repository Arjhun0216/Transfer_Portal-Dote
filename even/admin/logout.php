<?php
session_start();
unset($_SESSION['c_code']);
unset($_SESSION["name"]);
header("Location:log_in.php");
?>