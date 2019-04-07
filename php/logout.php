<?php
session_start();
session_destroy();
 
echo "<script>window.location.replace('../index.php?message=Successfully logged out&type=success');</script>";
?>