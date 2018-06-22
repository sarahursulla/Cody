<?php
session_start();
include("../php/script.php");
$_SESSION["MODE"] = 0;
header("Location:../html/signin.php");
?>
