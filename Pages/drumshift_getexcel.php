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
					    <th>Chal. No.</th>
                        <th>Date</th>
                        <th>Contractor Name</th>
                        <th>Name</th>
                        <th>From Plant</th>
                        <th>To Plant </th>
                        <th>Drum Series</th>
                        <th>Drum No.</th>
                        <th>Stage</th>
                        <th>No of core</th>
                        <th>Corepair</th>
                        <th>Sqmm</th>
                        <th>Conductor Type</th>
                        <th>Qnty</th>
                        <th>Unit</th>
                        <th>Remark</th>
				</tr>
			</thead>
			<tbody>
	';
	$sql = "SELECT * FROM Dshift where format(Date,'yyyy-MM')='$month' order by Date desc, id DESC   ";
	$run = sqlsrv_query($conn,$sql); 
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
		$output .= '
			<tr>
                <td>'. $row['Challanno'].'</td>
                <td>'. $row['Date']->format('d-m-Y').'</td>
                <td>'. $row['Name_of_contractor'].'</td>
                <td>'. $row['Name'].'</td>
                <td>'. $row['From_Plant'].'</td>
                <td>'. $row['To_Plant'].'</td>
                <td>'. $row['Drum_series'].'</td>
                <td>'. $row['Drum_No'].'</td>
                <td>'. $row['Stage'].'</td>
                <td>'. $row['No_of_core'].'</td>
                <td>'. $row['corepair'].'</td>
                <td>'. $row['Sqmm'].'</td>
                <td>'. $row['ConductorType'].'</td>
                <td>'. $row['Qnty'].'</td>
                <td>'. $row['Unit'].'</td>
                <td>'.$row['Remark'].'</td>
			</tr>
		';
	}
	$output .= '
		</tbody>
	</table>
	';

	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename=Dshift.xls');
	header('Content-Transfer-Encoding: Macro');

	echo $output;
}

