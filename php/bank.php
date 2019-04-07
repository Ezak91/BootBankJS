<?php
include('config.php');

if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    switch($action) {
        case 'getAccountNumbersForUser' : getAccountNumbersForUser();break;
        case 'getBalanceData' : getBalanceData();break;
        case 'getYearsForAccountNumber' : getYearsForAccountNumber();break;
        case 'getTransactions' : getTransactions();break;
        case 'getRevenueTransactions': getRevenueTransactions();break;
        case 'getExpenditureTransactions': getExpenditureTransactions();break;
        case 'getAverageInformation': getAverageInformation();break;
        case 'getRevenueData': getRevenueData();break;
        case 'getExpenditureData': getExpenditureData();break;
    }
}

function getAccountNumbersForUser() {
    global $conn;
    $userid = $_GET['userid'];
    $sql = "SELECT DISTINCT accountNumber from transactions where userid = $userid";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $accountNumbers[] = $row;
    }
    echo json_encode($accountNumbers);
    $result->close();
    $conn->close();
}

function getYearsForAccountNumber() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $sql = "SELECT DISTINCT year(date) as year from transactions where accountNumber = '$accountNumber' order by year(date) DESC";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $years[] = $row;
    }
    echo json_encode($years);
    $result->close();
    $conn->close();
}

function getTransactions() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $month = $_GET['month'];
    $userid = $_GET['userid'];

    $sql = "SELECT amount, purpose, applicant, date, entryDate from transactions where accountNumber = '$accountNumber' and userid = $userid and year(date) = $year and month(date) = $month ORDER BY date DESC";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode($transactions);
    $result->close();
    $conn->close();
}

function getRevenueTransactions() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $month = $_GET['month'];
    $userid = $_GET['userid'];

    $sql = "SELECT amount, purpose, applicant, date, entryDate from transactions where amount > 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year and month(date) = $month ORDER BY date DESC";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode($transactions);
    $result->close();
    $conn->close();
}

function getExpenditureTransactions() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $month = $_GET['month'];
    $userid = $_GET['userid'];

    $sql = "SELECT amount, purpose, applicant, date, entryDate from transactions where amount < 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year and month(date) = $month ORDER BY date DESC";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode($transactions);
    $result->close();
    $conn->close();
}

function getAverageInformation() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $userid = $_GET['userid'];
    $sql = "SELECT year(date) as year,sum(amount) as balance_sum,
     sum(amount)/count(Distinct month(date)) as balance_average,
     (select sum(amount) from transactions  WHERE amount > 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP BY year(date)) as revenue_sum,
     (select sum(amount) from transactions  WHERE amount > 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP BY year(date))/count(Distinct month(date)) as revenue_average,    
     (select sum(amount) from transactions  WHERE amount < 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP BY year(date)) as expenditure_sum,
     (select sum(amount) from transactions  WHERE amount < 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP BY year(date))/count(Distinct month(date)) as expenditure_average
     FROM transactions
     WHERE accountNumber = '$accountNumber' and userid = $userid and year(date) =  $year
     GROUP BY year(date)";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $averageInfo[] = $row;
    }
    echo json_encode($averageInfo);
    $result->close();
    $conn->close();    
}

function getBalanceData() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $userid = $_GET['userid'];
    $sql = " SELECT accountNumber, month(date) as month, sum(amount) as amountsum FROM transactions where accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP by accountNumber,month(date) ORDER BY month(date) ASC";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $chartData[] = $row;
    }
    echo json_encode($chartData);
    $result->close();
    $conn->close();
}

function getRevenueData() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $userid = $_GET['userid'];
    $sql = " SELECT accountNumber, month(date) as month, sum(amount) as revenuesum FROM transactions where amount > 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP by accountNumber,month(date) ORDER BY month(date) ASC";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $chartData[] = $row;
    }
    echo json_encode($chartData);
    $result->close();
    $conn->close();
}

function getExpenditureData() {
    global $conn;
    $accountNumber = $_GET['accountNumber'];
    $year= $_GET['year'];
    $userid = $_GET['userid'];
    $sql = " SELECT accountNumber, month(date) as month, sum(amount) as expendituresum FROM transactions where amount < 0 and accountNumber = '$accountNumber' and userid = $userid and year(date) = $year GROUP by accountNumber,month(date) ORDER BY month(date) ASC";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $chartData[] = $row;
    }
    echo json_encode($chartData);
    $result->close();
    $conn->close();
}

?>