<?php
session_start();
include('../includes/dbcon.php');
//include('../includes/header.php');  

if(isset($_POST['save'])){

$stype=$_POST['stype'];
$date=$_POST['fdate'];
$month=$_POST['month'];
$tname=$_POST['tname'];
$mp=$_POST['mp'];
$work=$_POST['work'];
$twt=$_POST['twt'];
$rate=$_POST['rate'];
$tamt=$_POST['tamt'];


$sql="INSERT INTO Oshift(Type,Date,Month,Teamname,workdet,mp,Totalwt,Rate,Amount,createdBy) 
VALUES('$stype','$date','$month','$tname','$work','$mp','$twt','$rate','$tamt','".$_SESSION['empid']."')";
$run= sqlsrv_query($conn,$sql);

if($run){
    ?>
    <script>
         window.open('othershift.php','_self');
    </script>
    <?php

}else{
    print_r(sqlsrv_errors());
}
}


//edit
if(isset($_POST['update'])){
    $id=$_POST['id'];
    $stype=$_POST['stype'];
    $date=$_POST['fdate'];
    $month=$_POST['month'];
    $tname=$_POST['tname'];
    $mp=$_POST['mp'];
    $work=$_POST['work'];
    $twt=$_POST['twt'];
    $rate=$_POST['rate'];
    $tamt=$_POST['tamt'];

$sql="UPDATE Oshift SET Type='$stype',Date='$date',Month='$month',Teamname='$tname',workdet='$work',mp='$mp',Totalwt='$twt',Rate='$rate',Amount='$tamt',
 UpdatedAt='".date('Y-m-d')."',UpdatedBy='".$_SESSION['empid']."' where id='$id' ";
 $run=sqlsrv_query($conn,$sql);

if($run){
    ?>
    <script>
        alert('updated Successfully');
        window.open('othershift.php','_self');
    </script>
    <?php
}else{
    print_r(sqlsrv_errors());
}

}
//delete
if(isset($_GET['delete'])){
    $id=$_GET['delete'];

    $sql="UPDATE Oshift SET Isdelete=1, UpdatedAt='".date('Y-m-d')."',UpdatedBy='".$_SESSION['empid']."' WHERE id ='$id'";
    $run=sqlsrv_query($conn,$sql);

if($run){
    ?>
    <script>
        alert('Deleted Successfully');
        window.open('othershift.php','_self');
    </script>
    <?php
    }else{
        print_r(sqlsrv_errors());
    }
}

//for qty
if(isset($_POST['stype1'])){
    $stype=$_POST['stype1'];
    
  
    $sql="SELECT rate from other_work where workdet='$stype' ";
  
    $run=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
    echo ($row['rate']);

}