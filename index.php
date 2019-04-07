<?php
session_start();
if(!isset($_SESSION['userid'])) {
    include("php/login.php");
}
else {
    include("bootbankjs.php");
}
?>