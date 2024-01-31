<?php
include('../includes/dbcon.php'); 


if(isset($_POST['ws'])){
    $mon=$_POST['mon'];
    $ws=$_POST['ws'];
    $tname=$_POST['tname'];
    $sql="SELECT Fromdate,Todate,wt_scale,Teamname from scraphead where Month='$mon' and wt_scale='$ws' ";

    $run=sqlsrv_query($conn,$sql);
    $table = '<table class="table table-bordered text-center mb-0">
                <thead>
                    <th>Ws</th>
                    <th>Tname</th>
                    <th>Fdate</th>
                    <th>Tdate</th>
                    <th>View</th>
                </thead>
                <tbody>';

    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $table .= '<tr>
                    <td>'.$row['wt_scale'].'</td>
                    <td>'.$row['Teamname'].'</td>
                    <td>' . $row['Fromdate']->format('d-m-Y') . '</td>
                    <td>' . $row['Todate']->format('d-m-Y') . '</td>
                    <td><button class="btn btn-sm rounded-pill btn-warning datechange" id="'.$row['Fromdate']->format('Y-m-d').'" data-todate="'.$row['Todate']->format('Y-m-d').'">View</button></td>
                </tr>';
    }

    $table .= '</tbody></table>';
   

 $sql2="SELECT count(*) as cn,format(max(Todate) ,'yyyy-MM-dd') as t, wt_scale from scraphead where Month='$mon' and wt_scale='$ws'and Teamname='$tname' group by wt_scale";
 $run2=sqlsrv_query($conn,$sql2);
 $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC);
$t=$row2['t'] ?? '1900-01-01';

$responseData = array(
    'table' => $table,
    't' => $t
);

// Send JSON response
echo json_encode($responseData);
}

?>

