<?php
include('../includes/dbcon.php');

if (true) {
    $month=$_POST['month'];

    echo date('F-y',strtotime($month));
 


	$output = '';

	$output .='
		<table border="1">
			<thead>
				<tr>
					    <th>id</th>
                      
                        <th>Type </th>
                        <th>From date</th>
                        <th>Month</th>
                        <th>Teamname</th>
                        <th>mp </th>
                        <th>Total Wt</th>
                        <th>Total Amt</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Amount</th>
				</tr>
			</thead>
			<tbody>
	';
	$sql = "SELECT a.id, a.Typeofscrap,a.Fromdate,a.Month,a.Teamname,a.mp,a.Totalwt,a.Totalamt,b.Type,b.Name,b.Remark,b.qnty,b.rate,b.amount FROM scraphead a inner join scrapdetail b
    on a.id=b.head_id where format(a.Fromdate,'yyyy-MM')='$month' order by a.fromdate desc, a.id DESC";
	$run = sqlsrv_query($conn,$sql); 
    $sr=0;
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
       
        if($sr!=0 && $sr==$row['id'] ){
            $output .= '
			<tr>
                <td></td>
                
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>'. $row['Type'].'</td>
                <td>'. $row['Name'].'</td>
                <td>'. $row['Remark'].'</td>
                <td>'. $row['qnty'].'</td>
                <td>'. $row['rate'].'</td>
                <td>'. $row['amount'].'</td>
              
			</tr>
	
    ';
           
        }else{
            $output .= '
			<tr>
                <td>'. $row['id'].'</td>
                <td>'. $row['Typeofscrap'].'</td>
                <td>'. $row['Fromdate']->format('d-m-Y').'</td>
                <td>'. $row['Month'].'</td>
                <td>'. $row['Teamname'].'</td>
                <td>'. $row['mp'].'</td>
                <td>'. $row['Totalwt'].'</td>
                <td>'. $row['Totalamt'].'</td>
                <td>'. $row['Type'].'</td>
                <td>'. $row['Name'].'</td>
                <td>'. $row['Remark'].'</td>
                <td>'. $row['qnty'].'</td>
                <td>'. $row['rate'].'</td>
                <td>'. $row['amount'].'</td>
              
			</tr>
		';
           

        }
        $sr=$row['id'];
	
	}
	$output .= '
		</tbody>
	</table>
	';

	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename=Scrap.xls');
	header('Content-Transfer-Encoding: Macro');

	echo $output;
}

