<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die("Please login first");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      
    <link href="style/dashboard.css" rel="stylesheet">  
    <!-- CSS -->  
    <title>BootBankJS</title>
  </head>
  <body>
    <?php
    $userid = $_SESSION['userid'];
    echo "<input type='hidden' id='inputUserid' name='register' value='$userid'>";
    ?>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
          BootBankJS
          <span data-feather="dollar-sign"> </span>
        </a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
            <a class="nav-link" href="php/logout.php">Sign out</a>
          </li>
        </ul>
      </nav>
      
      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" href="#">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" onclick="loadBalance()">
                    <span data-feather="bar-chart-2"></span>
                    Balance
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" onclick="loadRevenue()">
                    <span data-feather="trending-up"></span>
                    Revenue
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" onclick="loadExpenditure()">
                    <span data-feather="trending-down"></span>
                    Expenditure
                  </a>
                </li>                                   
              </ul>
            </div>
          </nav>
      
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Dashboard</h1>
              <div class="btn-toolbar mb-1 mb-md-0">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="accountSelect">
                      <span data-feather="book-open" class="input-icon"> </span>
                       Accountnumber
                    </label>
                  </div>
                  <select class="custom-select" id="accountSelect">
                  </select>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="yearSelect">
                      <span data-feather="calendar" class="input-icon"> </span
                        >Year
                      </label>
                  </div>
                  <select class="custom-select" id="yearSelect">
                  </select>
                </div>
              </div>
            </div>
      
               <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
      
            <h2>Transactions</h2>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="transaction-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Entrydate</th>
                    <th>Applicant</th>
                    <th>Purpose</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <h2>Sum and Average</h2>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="average-table">
                <thead>
                  <tr>
                    <th>Revenue sum</th>
                    <th>Revenue average / month</th>
                    <th>Expenditure sum</th>
                    <th>Expenditure average / month</th>
                    <th>Balance sum</th>
                    <th>Balance average / month</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

          </main>
        </div>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="scripts/dashboard.js"></script>  
</body>
</html>