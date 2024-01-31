<?php
include('../includes/dbcon.php');
session_start();

    if( true){
        $Challanno=$_POST['challanno'];
            // $Date=$_POST['Date'];
            // $Name_of_contractor=$_POST['Name_of_contractor'];
            // $Name=$_POST['Name'];
            // $From_Plant=$_POST['From_Plant'];
            // $To_Plant=$_POST['To_Plant'];
            // $Drum_series=$_POST['Drum_series'];
            // $Drum_No=$_POST['Drum_No'];
        $checkbox_state=$_POST['checkbox_state'];
        $id=$_POST['id'];
      
    
       foreach($checkbox_state as $key => $value){
        $sql1="SELECT  count(*) as c from Challan where Dshift_id='$id[$key]'";
        $run1=sqlsrv_query($conn,$sql1);
        $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
    
      
    
        if($value==1 && $row1['c']< 1){
            $sql="INSERT INTO Challan (Challanno,Dshift_id,is_set,createdBy)
            VALUES('$Challanno','".$id[$key]."','1','".$_SESSION['empid']."')";
            $run=sqlsrv_query($conn,$sql);

        }
       }
       if($run){
            echo("Challan Verified");
        }else{
            print_r(sqlsrv_errors());
        }

    
        }

        ?>
