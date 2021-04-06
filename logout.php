<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["userid"]);
unset($_SESSION['charuid']);
header("Location:index.php");
?>