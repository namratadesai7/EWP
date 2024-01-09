<?php
include('../includes/dbcon.php');


?>
 <table class="table table-bordered text-center table-striped table-hover mb-0" id="drumTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Chal. No.</th>
                        <th>Date</th>
                        <th>Contractor Name</th>
                        <th>Name</th>
                        <th>From Plant</th>
                        <th>To Plant </th>
                        <th>Drum Series</th>
                        <th>Drum No.</th>
                        <!-- <th>Stage</th>
                        <th>No of Core</th>
                        <th>Core/Pair</th>
                        <th>Sqmm</th>
                        <th>Cond. Type</th>
                        <th>Qnty</th> -->
                        <th>Remark</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <?php
                            $sr=1;
                            $sql="SELECT * FROM Dshift order by Date desc, id DESC";
                            $run=sqlsrv_query($conn,$sql);
                            
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                        ?>
                            <tr>
                                <td><?php echo $row['Challanno']  ?></td>
                                <td><?php echo $row['Date']->format('d-m-Y')  ?></td>
                                <td><?php echo $row['Name_of_contractor']  ?></td>
                                <td><?php echo $row['Name']  ?></td>
                                <td><?php echo $row['From_Plant']  ?></td>
                                <td><?php echo $row['To_Plant']  ?></td>
                                <td><?php echo $row['Drum_series']  ?></td>
                                <td><?php echo $row['Drum_No']  ?></td>
                                <!-- <td><?php echo $row['Stage']  ?></td>
                                <td><?php echo $row['No_of_core']  ?></td>
                                <td><?php echo $row['corepair']  ?></td>
                                <td><?php echo $row['Sqmm']  ?></td>
                                <td><?php echo $row['ConductorType']  ?></td>
                                <td><?php echo $row['Qnty'].' '.$row['Unit'] ?></td> -->
                                <td><?php echo $row['Remark']  ?></td>
                                <td class="tdCss"><a href="drumshift_edit.php?edit=<?php echo $row['id']?>" class="btn rounded-pill btn-warning btn-sm" >Edit</a></td>
                            </tr>
                        <?php
                         $sr++;  }
                        ?>                                       
                </tbody>
            </table>

            <script>
                  $(document).ready(function(){
		var table = $('#drumTable').DataTable({   // initializes a DataTable using the DataTables library 
		    "processing": true,                  //This option enables the processing indicator to be shown while the table is being processed
			 dom: 'Bfrtip',                      // This option specifies the layout of the table's user interface B-buttons,f-flitering input control,T-table,I-informationsummary,P-pagination
			 ordering: false,                   //sort the columns by clicking on the header cells if true
			 destroy: true,                     //This option indicates that if this DataTable instance is re-initialized, 
                                                //the previous instance should be destroyed. This is useful when you need to re-create the table dynamically.
            
		 	lengthMenu: [
            	[ 15, 25, -1 ],
            	[ '15 rows','25 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
 	});
            </script>