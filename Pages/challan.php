<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
$mon=date('m');
$year=date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challan</title>
    <style>

        .fl{
            margin-top:2rem;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
       
        .tdCss{
            padding: 3px 6px !important;
        }
        #challantable th,
        #challantable td {
            text-align: center;
        }
        .modal-xl{
            max-width: 1400px !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid fl ">
        <div class="row mb-3">
            <div class="col"><h4 class="pt-2 mb-0">Challan</h4></div>
            <div class="col-auto">
                    <input class="form-control" type="month" name="month" id="month" >
                </div>
                <div class="col-auto">
                    <button type="button" id="verified" class="btn btn-rounded btn-success">Verified</button>
                </div>
                <div class="col-auto">
                    <button href="challan.php" type="a" id="pending" class="btn btn-rounded btn-warning">Pending</button>
                </div>
            
        </div>
        <div class="divCss ">
            <div  id="showdata">
            <table class="table table-bordered table-sm text-center table-striped table-hover mb-0" id="challantable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr</th>
                        <th>Challan No.</th>
                        <th>Date</th>
                        <th>Name of contractor</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                        <?php
                            $sr=1;                          
                            $sql="SELECT DISTINCT(Challanno),Date,Name_of_contractor FROM Dshift where format(Date,'MM')='$mon'
                             and format(Date,'yyyy')='$year'  and (Type='drums' or Type is null) and Challanno not in (select distinct(Challanno) from Challan)
                               order by  Date desc ";
                            
                            $run=sqlsrv_query($conn,$sql);
                            $printedSrNos = array();
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){                                                
                        ?>
                            <tr>
                                <td ><?php echo $sr?></td>
                                <td><?php echo $row['Challanno'] ?></td>
                                <td ><?php echo $row['Date']->format('d-m-Y')  ?></td>
                                <td class="tname" ><?php echo $row['Name_of_contractor']  ?></td>                
                                <td  class="tdCss" >
                                    <a class="btn rounded-pill btn-warning btn-sm view" id="<?php echo $row['Challanno'] ?>"  >View</a>                                   
                                    <a href="challanpdf.php?pdf=<?php echo $row['Challanno']?>" style=" font-size: 12px;" class="btn btn-danger btn-sm rounded-pill">Pdf</a>
                                </td>
                            </tr>
                        <?php
                      $sr++; 
                         }
                        ?>                                       
                </tbody>
            </table>
            </div>
        <!-- Challan modal -->
        <div class="modal fade" id="verifymodal" tabindex="-1" aria-labelledby="verifymodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="abc">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-pill common-btn" name="verifyform" id="verifyform">Save</button>
                    </div>
                </div>
            </div>
        </div>

 
        </div>
    </div>
</body>
</html>
<script>

    $(document).on('click','#verifyform', function(){
         
            $.ajax({                                    
                url:'challan_db.php',
                type:'post',
                data:$('#verform').serialize(),       
                                                        
                success:function(response){  
                    alert(response);
                    window.location.reload();
            },
            error:function(abc){
                console.log(abc);
            }
        })
    });
     $('#challan').addClass('active');
    //modal for summary      
    $(document).on('click','.view',function(){
        // Find the closest parent row of the clicked "drums" element
        var challanno=$(this).attr('id');
        
        $.ajax({
            url:'challan_modal.php',
            type: 'post',
            data: {challanno:challanno},  
            // dataType: 'json',
            success:function(data){
              $('#abc').html(data);  
              $('#verifymodal').modal('show');
            }
          });
        });

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

    $(document).on('change', '#month', function () {
        var month = $('#month').val();


        // Split the selected month and year
        var [year, selectedMonth] = month.split('-');

        // Convert the selected month to two-digit format (e.g., '01' for January)
        var formattedMonth = ('0' + selectedMonth).slice(-2);
    

    // Now you can send the formattedMonth through AJAX
    $.ajax({
        url: 'Challan_month.php',
        type: 'post',
        data: {
            month: formattedMonth,
            year: year
        },
        success: function (data) {
            $('#showdata').html(data);
        },
        error: function (res) {
        }
    });
});
$(document).on('click','#verified', function(){
    var month = $('#month').val();
 
    var [year, selectedMonth] = month.split('-');

    // Convert the selected month to two-digit format (e.g., '01' for January)
    var formattedMonth = ('0' + selectedMonth).slice(-2);
    
        $.ajax({
            url:'challan_verified.php',
            type:'post',
            data:{  month:formattedMonth,
            year: year
        },
            success:function(data){
                //$('#showver').html(data);  
                $('#showdata').html(data);  
            },
            error:function(res){
                console.log(res);
            }
        })
    });

$(document).on('click','#pending', function(){
    var month = $('#month').val();
    
    var [year, selectedMonth] = month.split('-');

    // Convert the selected month to two-digit format (e.g., '01' for January)
    var formattedMonth = ('0' + selectedMonth).slice(-2);
    
        $.ajax({
            url:'challan_pending.php',
            type:'post',
            data:{  month:formattedMonth,
            year: year
        },
            success:function(data){
                //$('#showver').html(data);  
                $('#showdata').html(data);  
            },
            error:function(res){
                console.log(res);
            }
        })
    });
  
 

     $(document).ready(function(){
		var table = $('#challantable').DataTable({   // initializes a DataTable using the DataTables library 
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