<?php
include('../includes/dbcon.php');
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());

// Get To Month based on From month
if (isset($_POST['month'])) {
    $fmonth = $_POST['month'];
    $emonth = date("Y-m", strtotime($fmonth . "+5 months"));
    echo $emonth;
}

// Add Rate for 6 months
if (isset($_POST['submit'])) {
    $rate = $_POST['rate'];
    $fmonth = $_POST['fmonth'];
    $query = "SELECT MAX(iId) as Id FROM emp_rate_master";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    $Id = $crow['Id'] + 1;
    for ($i=0; $i < 6; $i++) {
        $emonth = date("Y-m", strtotime($fmonth . "+$i months"));
        //echo $emonth. '<br>';
        $sql = "INSERT INTO emp_rate_master(iId,rate,month,isDelete) values('$Id','$rate','$emonth','0')";
        $run = sqlsrv_query($conn, $sql);

        if ($run) {
            header('Location: emp_rate_master.php');
            $_SESSION['insert'] = "Data Inserted Successfully";
        } else {
            print_r(sqlsrv_errors());
        }
    }
}

// Edit Rate

if (isset($_POST['id'])) {
    $id = $_POST['id'];
   
    $rate = $_POST['rate'];
    
    $sql = "UPDATE emp_rate_master SET rate='$rate',updatedAt='$cur_date', updatedBy='$user' where iId='$id'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:emp_rate_master.php');
        $_SESSION['update'] = "Data Updated Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}
?>