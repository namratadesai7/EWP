<?php
include('../includes/dbcon.php');
session_start();

if(isset($_POST['recdate'])){
    $inw_id=$_POST['inw_id'];
    $tqty=$_POST['tqty'];
   //print_r($inw_id);
    $recdate=$_POST['recdate'];
    $mon=$_POST['mon'];
    $invno=$_POST['invno'];
    $invdate=$_POST['invdate'];
    $partyn=$_POST['partyn'];
    $item=$_POST['item'];
    $pkg=$_POST['pkg'];
    $qty=$_POST['qty'];
    $rate=$_POST['rate'];
    $amt=$_POST['amt'];
    $checkbox_state=$_POST['checkbox_state'];
    $main_grad=$_POST['main_grad'];

    $sql1="select sum(qnty) as sum from purchase_data where month='$mon' and main_grade='$main_grad' and inw_id= 0  ";
    $run1=sqlsrv_query($conn,$sql1);
    $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

    if($row1['sum']>0){
        $tqty+=$row1['sum'];
        // echo $tqty;
    

    }else{
        $tqty=$tqty;
    }

    foreach ($inw_id as $key => $value) {
       
        $sql="INSERT INTO purchase_data(inw_id,tqty,rcv_date,month,main_grade,inv_no,inv_date,party,item,qnty,rate,basic_amt,pkg,is_cancel) 
        VALUES('".$value."','$tqty','".$recdate[$key]."','$mon','$main_grad','".$invno[$key]."','".$invdate[$key]."','".$partyn[$key]."', '".$item[$key]."',
        '".$qty[$key]."','".$rate[$key]."','".$amt[$key]."','".$pkg[$key]."','".$checkbox_state[$key]."')";
        $run=sqlsrv_query($conn,$sql);
    //    echo  $sql.'<br>';
    }
    
    $sql2="update purchase_data set tqty='$tqty' where month='$mon' and main_grade='$main_grad' and inw_id= 0 ";
    $run2=sqlsrv_query($conn,$sql2);

    $response = array('tqty' => $tqty);

    if($run && $run2){
        // echo json_encode($response);
        echo "save";
    }else{
        print_r(sqlsrv_errors());

    }
}
