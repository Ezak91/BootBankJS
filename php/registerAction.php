<?php
if(isset($_POST['register'])) {
    include('config.php');
    $account = $_POST['bankAccount'];
    $bankCode = $_POST['bankCode'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

    if($password == $passwordRepeat) {
        $passwordHash = crypt($password);
        $sql = "INSERT INTO user (username,bankcode,password) VALUES ('$account','$bankCode','$passwordHash')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.replace('../index.php?message=User $account successfully registered&type=success');</script>";
        } else {
            echo "<script>window.location.replace('register.php?message=Fehler bei der Anmeldung&type=danger');</script>";
        }
    }
    else {
        echo "<script>window.location.replace('register.php?message=Password does not match&type=danger');</script>";
    }
}
else {
    echo "Ups you are wrong here";
}
?>