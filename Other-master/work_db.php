<?php
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());
include('../includes/dbcon.php');

// Add Plant
if (isset($_POST['submit'])) {
    $work = $_POST['work'];
    $rate = $_POST['rate'];



    $sql = "INSERT INTO other_work (workdet,rate,createdBy) values ('$work','$rate','$user')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location: work.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}
// Delete Plant
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "UPDATE other_work SET isDelete = '1' where id=$id";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:work.php');
        $_SESSION['delete'] = "Data Deleted Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}
// Edit Plant
if (isset($_POST['update'])) {
    $editName = $_POST['editMaterial'];
    $editRate = $_POST['editRate'];
    $editId = $_POST['editId'];

    $sql = "UPDATE other_work SET workdet='$editName',rate='$editRate' ,updatedAt='$cur_date', updatedBy='$user' where id='$editId'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:work.php');
        $_SESSION['update'] = "Data Updated Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}
?>