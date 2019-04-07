<?php
session_start();
if(isset($_POST['login'])) {
    include('config.php');
    $account = $_POST['bankAccount'];
    $bankCode = $_POST['bankCode'];
    $password = $_POST['password'];

    $sql = "SELECT id,password from user where username = '$account' and bankcode = '$bankCode'";
    $result = $conn->query($sql);

    $pwcheck;
    $userid;
    while($row = $result->fetch_assoc()) {
        $pwcheck = $row['password'];
        $userid = $row['id'];
    }
    if ($userid && password_verify($password, $pwcheck)) {
        $_SESSION['userid'] = $userid;
        echo "<script>window.location.replace('../index.php');</script>";
    }
    else {
        echo "<script>window.location.replace('../index.php?message=Login failed&type=danger');</script>";
    }
}
else {
    echo "Ups you are wrong here";
}
?>