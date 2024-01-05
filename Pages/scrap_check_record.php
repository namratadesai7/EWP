<?php
include('../includes/dbcon.php'); 



// for chekcing records in scrap data
if (isset($_POST['fdate']) && isset($_POST['tdate']) && isset($_POST['wscale'])) {
    $fdate = $_POST['fdate'];
    $tdate = $_POST['tdate'];
    $wscale = $_POST['wscale'];

    // Perform a database query to check if the record exists
    $sql ="SELECT COUNT(*) AS count FROM scraphead WHERE Fromdate = '$fdate' AND Todate = '$tdate' AND wt_scale='$wscale'";
    $run = sqlsrv_query($conn,$sql);
    
    if ($run) {
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $count = $row['count'];

        if ($count > 0) {
            // The record exists
            echo "exists";
        } else {
            // The record does not exist
            echo "not_exists";
        }
    }else {
        // Error handling for the database query
        echo "error";
    }
}
else {
    // Handle the case where 'month' or 'cont' is not set in the POST data
    echo "missing_data";
}



?>
