/* global vars */
var myChart;
var labelArray;
var dataArray;
var lastmonth;
var userid = $("#inputUserid").val();
var functionName = 

/* Events */

/* Accountnumber changed */
$( "#accountSelect" ).change(function() {
  getYearsForAccountNumber();
  loadFunction();
});

/* Year changed */
$( "#yearSelect" ).change(function() {
  loadFunction();
});

// Set the global configs to synchronous 
$.ajaxSetup({
  async: false
});

window.onload = function () {
  getAccountNumbersForUser();
  getYearsForAccountNumber();
  functionName = 'loadBalance';
  loadFunction();  
}

function loadFunction() {
  switch(functionName) {
    case 'loadBalance':
      loadBalance();
      break;
    case 'loadRevenue':
      loadRevenue();
      break;
    case 'loadExpenditure':
      loadExpenditure();
      break;
  } 
}

/* Load balance */
function loadBalance() {
  functionName = 'loadBalance';
  getBalanceData(); 
  drawChart('bar','false');
  getTransactions(lastmonth,'getTransactions');
  getAverageInformation();
}

/* Load revenue */
function loadRevenue() {
  functionName = 'loadRevenue';
  getRevenueData();
  drawChart('line','true');
  getTransactions(lastmonth,'getRevenueTransactions');
  getAverageInformation();
}

/* Load expenditure */
function loadExpenditure() {
  functionName = 'loadExpenditure';
  getExpenditureData();
  drawChart('line','true');
  getTransactions(lastmonth,'getExpenditureTransactions');
  getAverageInformation();
}

/* click bar */
function clickHandler(evt) {
  var firstPoint = myChart.getElementAtEvent(evt)[0];

  if (firstPoint) {
      var label = myChart.data.labels[firstPoint._index];
      var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
      //get month number from month name
      month = new Date(Date.parse(label +" 1, 2012")).getMonth()+1
      switch(functionName) {
        case 'loadBalance':
           getTransactions(month,'getTransactions');
          break;
        case 'loadRevenue':
          getTransactions(month,'getRevenueTransactions');
          break;
        case 'loadExpenditure':
          getTransactions(month,'getExpenditureTransactions');
          break;
      } 
  }
}

/* get accountnumbers for user */
function getAccountNumbersForUser() {
  $.getJSON('php/bank.php', { userid: userid, action: 'getAccountNumbersForUser'}, function(data) {
    $.each(data, function(i, field){
      $("#accountSelect").append(new Option(field['accountNumber'], field['accountNumber']));
      });
  });  
};

/* get years for accountnumber */
function getYearsForAccountNumber() {
  $("#yearSelect").find("option").remove().end();
  $account = $("#accountSelect").children("option:selected").val();
  $.getJSON('php/bank.php', { accountNumber: $account, action: 'getYearsForAccountNumber'}, function(data) {
        
    $.each(data, function(i, field){
      $("#yearSelect").append(new Option(field['year'], field['year']));
    });    
  });
};

/* get transactions for account,year and month */
function getTransactions(month,action) {
  $accountNumber = $("#accountSelect").children("option:selected").val();
  $year = $("#yearSelect").children("option:selected").val();
  $.getJSON('php/bank.php', { accountNumber: $accountNumber, userid: userid, year: $year, month: month, action: action}, function(data) {
    $("#transaction-table tbody").empty();   
    $.each(data, function(i, field){
      var amount = field['amount'];
      var purpose = field['purpose'];
      var applicant = field['applicant'];
      var date = field['date'];
      var entryDate = field['entryDate'];
      var row = "<tr>";
      row += "<td>" + date + "</td>";
      row += "<td>" + entryDate + "</td>";
      row += "<td>" + applicant + "</td>";
      row += "<td>" + purpose + "</td>";
      row += "<td>" + "<div class='" + getAmountClass(amount) + "'>" + amount + "</div></td>";
      row += "</tr>";
      $("#transaction-table tbody").append(row);
    });   
  });
};

/* get average informationen for account and year */
function getAverageInformation() {
  $accountNumber = $("#accountSelect").children("option:selected").val();
  $year = $("#yearSelect").children("option:selected").val();
  $.getJSON('php/bank.php', { accountNumber: $accountNumber, userid: userid, year: $year, action: 'getAverageInformation'}, function(data) {
    $("#average-table tbody").empty();   
    $.each(data, function(i, field){
      var revenueSum = field['revenue_sum'];
      var revenueAverage = Number(field['revenue_average']).toFixed(2);
      var expenditureSum = field['expenditure_sum'];
      var expenditureAverage = Number(field['expenditure_average']).toFixed(2);
      var balanceSum = field['balance_sum'];
      var balanceAverage = Number(field['balance_average']).toFixed(2);
      var row = "<tr>";
      row += "<td>" + "<div class='" + getAmountClass(revenueSum) + "'>" + revenueSum + "</div></td>";
      row += "<td>" + "<div class='" + getAmountClass(revenueAverage) + "'>" + revenueAverage + "</div></td>";
      row += "<td>" + "<div class='" + getAmountClass(expenditureSum) + "'>" + expenditureSum + "</div></td>";
      row += "<td>" + "<div class='" + getAmountClass(expenditureAverage) + "'>" + expenditureAverage + "</div></td>";
      row += "<td>" + "<div class='" + getAmountClass(balanceSum) + "'>" + balanceSum + "</div></td>";
      row += "<td>" + "<div class='" + getAmountClass(balanceAverage) + "'>" + balanceAverage + "</div></td>";
      row += "</tr>";
      $("#average-table tbody").append(row);
    });   
  });    
};

/* get class for amount */
function getAmountClass(amount) {
  if(amount < 0) {
    return 'negative';
  }
  return 'positive';
};

/* get balance data for chart */
function getBalanceData() {
    labelArray = [];
    dataArray = [];
    $accountNumber = $("#accountSelect").children("option:selected").val();
    $year = $("#yearSelect").children("option:selected").val();
    $.getJSON('php/bank.php', { accountNumber: $accountNumber, userid: userid, year: $year, action: 'getBalanceData'}, function(data) {
        $.each(data, function(i, field){
            date = new Date('1919-'+field['month']+'-28');
            month = date.toLocaleString('en-us', { month: 'long' });
            labelArray.push(month);
            dataArray.push(field['amountsum']);
            lastmonth = field['month'];
          }); 
    });
};

/* get revenue data for chart */
function getRevenueData() {
  labelArray = [];
  dataArray = [];
  $accountNumber = $("#accountSelect").children("option:selected").val();
  $year = $("#yearSelect").children("option:selected").val();
  $.getJSON('php/bank.php', { accountNumber: $accountNumber, userid: userid, year: $year, action: 'getRevenueData'}, function(data) {
      $.each(data, function(i, field){
          date = new Date('1919-'+field['month']+'-28');
          month = date.toLocaleString('en-us', { month: 'long' });
          labelArray.push(month);
          dataArray.push(field['revenuesum']);
          lastmonth = field['month'];
        }); 
  });
};

/* get expenditure data for chart */
function getExpenditureData() {
  labelArray = [];
  dataArray = [];
  $accountNumber = $("#accountSelect").children("option:selected").val();
  $year = $("#yearSelect").children("option:selected").val();
  $.getJSON('php/bank.php', { accountNumber: $accountNumber, userid: userid, year: $year, action: 'getExpenditureData'}, function(data) {
      $.each(data, function(i, field){
          date = new Date('1919-'+field['month']+'-28');
          month = date.toLocaleString('en-us', { month: 'long' });
          labelArray.push(month);
          dataArray.push(field['expendituresum']);
          lastmonth = field['month'];
        }); 
  });
};

/* draw chart */
function drawChart(type,zero) {
  'use strict'
  feather.replace()

if (myChart) { 
  myChart.destroy(); 
}

var ctx = document.getElementById("myChart").getContext("2d");

  myChart = new Chart(ctx, {
    type: type,
    data: {
      labels: labelArray,
      datasets: [{
        data: dataArray,
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: zero
          }
        }]
      },
      legend: {
        display: false
      },
    }
  })

  var canvas = document.getElementById("myChart");
  canvas.onclick = function(evt) {
    clickHandler(evt);
  }
}