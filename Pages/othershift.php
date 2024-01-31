<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
$mon=date('F');
$year=date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Shifting</title>
    <style>
         /* .hideText{
            color: transparent !important;
          
        }
        .btnhide{
            background: transparent !important;
            border: none !important;
            font-size:0 !important;
        } */
        .fl{
            margin-top:2rem;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        .row{
            
        }
        #drumTable th{
            white-space: nowrap !important;
           /* font-size:0.8rem; */
            padding: 8px 6px;
            /* padding-left:0;
            padding-right:0; */
        }
        #drumTable td{
            white-space:nowrap;
          /* font-size:1rem; */
            padding: 6px;
             /* padding-left:0;
            padding-right:0; */
        }
        .tdCss{
            padding: 3px 6px !important;
        }
        #oshifttable th,
    #oshifttable td {
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="container-fluid fl ">
        <div class="row mb-3">
            <div class="col"><h4 class="pt-2 mb-0">Other Shifting</h4></div>
            <div class="col-auto">
                    <input class="form-control" type="month" name="month" id="month" >
                </div>
            <div class="col-auto"> <a  class="btn rounded-pill common-btn" href="Oshift_add.php">+Add</a></div>
        </div>
        <div class="divCss ">
            <div  id="showdata">
            <table class="table table-bordered text-center table-striped table-hover mb-0" id="oshifttable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr</th>
                        <th>Type</th>
                        <th>FDate</th>
                        <th>Month</th>
                        <th>Team Name</th>
                        <th>M.p</th>
                        <th>Work</th>
                        <th>Total WT/Qty</th>
                        <th>Rate</th>
                        <th> Amt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                        <?php
                            $sr=1;
                          
                            $sql="SELECT id, Type,Date,Month, Teamname,workdet,mp, Totalwt, Rate,Amount
                            FROM Oshift 
                           where Month='$mon' and format(Date,'yyyy')='$year' and Isdelete='0' ";
                            $run=sqlsrv_query($conn,$sql);
                            $printedSrNos = array();
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                                                      
                        ?>
                            <tr>
                            
                                <td ><?php echo $sr ?></td>
                                <td  ><?php if($row['Type'] =='Manpower'){ echo "Manpower";
                                 }elseif($row['Type'] =='Drum  Wrapping'){ echo "Drum  Wrapping"; }    ?></td>
                                <td ><?php echo $row['Date']->format("Y-m-d") ?></td>
                             
                                <td ><?php echo $row['Month']  ?></td>
                                <td ><?php echo $row['Teamname']  ?></td>
                                <td ><?php echo $row['mp']  ?></td>
                                <td><?php echo $row['workdet'] ?></td>
                          
                                <td ><?php echo $row['Totalwt']  ?></td>
                                <td ><?php echo $row['Rate']  ?></td>    
                                <td ><?php echo $row['Amount']  ?></td>   
                                                    
                                <td  class="tdCss" ><a href="Oshift_edit.php?edit=<?php echo $row['id']?>"  class="btn rounded-pill btn-warning btn-sm"  >Edit</a>
                                <a href="Oshift_db.php?delete=<?php echo $row['id'] ?>" class="btn rounded-pill btn-danger btn-sm delete" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a></td>
                            </tr>
                        <?php
                     $sr++; 
                         }
                        ?>                                       
                </tbody>
            </table>
            </div>

 
        </div>
    </div>
</body>
</html>
<script>
     $('#oshift').addClass('active');


     var currentDate = new Date();

    // Get the current month and year
    var currentMonth = currentDate.getMonth() + 1; // Months are zero-based
    var currentYear = currentDate.getFullYear();

    // Pad the month with leading zero if needed
    if (currentMonth < 10) {
        currentMonth = '0' + currentMonth;
    }

    // Set the value of the input element to the current month
    document.getElementById('month').value = currentYear + '-' + currentMonth;

     $(document).on('change','#month',function(){
            var month=$('#month').val();
         
            var [year, month] = month.split('-');
            var date = new Date(year, month - 1);

            // Use toLocaleString to get the month name
            var monthName = date.toLocaleString('en-US', { month: 'long' });
            
          
     })

     $(document).ready(function(){
		var table = $('#oshifttable').DataTable({   // initializes a DataTable using the DataTables library 
		    "processing": true,                  //This option enables the processing indicator to be shown while the table is being processed
			 dom: 'Bfrtip',                      // This option specifies the layout of the table's user interface B-buttons,f-flitering input control,T-table,I-informationsummary,P-pagination
			 ordering: false,                   //sort the columns by clicking on the header cells if true
			 destroy: true,                     //This option indicates that if this DataTable instance is re-initialized, 
                                                //the previous instance should be destroyed. This is useful when you need to re-create the table dynamically.
            
		 	lengthMenu: [
            	[ 15, 50, -1 ],
            	[ '15 rows','50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
 	});
</script>
<?php

include('../includes/footer.php');
?>