<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BootBankJS Register</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">   
    <link href="../style/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="POST" action="registerAction.php">
        <?php
        if(isset($_GET['message']) && isset($_GET['type'])) {
          $message = $_GET['message'];
          $type = $_GET['type'];
          echo "<div class='alert alert-$type' role='alert'>$message</div>";
        }
        ?>

            <img class="mb-4" src="../icons/bootbankjs.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">BootBankJS Register</h1>
            <label for="inputAccount" class="sr-only">Bank Account</label>
            <input type="text" id="inputAccount" class="form-control" name="bankAccount" placeholder="Bank Account" required autofocus>
            <label for="inputBankCode" class="sr-only">Bank Code</label>
            <input type="text" id="inputBankCode" class="form-control" name="bankCode" placeholder="Bank Code" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" name="password" placeholder="BootBankJS Password" required>
            <label for="inputPasswordRepeat" class="sr-only">Repeat Password</label>
            <input type="password" id="inputPasswordRepeat" class="form-control" name="passwordRepeat" placeholder="Repeat Password" required>
            <input type="hidden" id="inputRegister" name="register" value="1">            
            <button class="btn btn-lg btn-primary btn-block" id="register-btn" type="submit">Register</button>
            <a href="../index.php" id="register-link">
                <button class="btn btn-lg btn-secondary btn-block" type="button">Sign in</button>
            </a>
            <p class="mt-5 mb-3 text-muted">&copy; BootBankJS</p>
        </form>
    </body>
</html>