<?php
include('../includes/dbcon.php');
$challanno=$_POST['challanno'];
// $date=$_POST['date'];
// $tname=$_POST['tname'];
// $month = date('m', strtotime("$date"));
// $year = date('Y', strtotime("$date"));

?>
<style>
        #challanmodaltab input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width:50%;
            text-align: center;
            padding:0px !important;
        }
      #challanmodaltab
{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }

        #challanmodaltab th,
        #challanmodaltab td {
            text-align: center ;
            white-space:nowrap;
    }
</style>
<div class="row">
<div class="col"></div>
<div class="col-auto">
<input type="checkbox" id="checkAll"> Check All
</div>
</div>

<form id="verform">
    <table class="table table-bordered text-center table-striped table-hover mt-7" id="challanmodaltab">

   <thead>
        <tr class="bg-secondary text-light">
            <th>Sr No.</th>
            <th>Chal. No.</th>
            <th>Date</th>
            <th>Contractor Name</th>
            <th>Name</th>
            <th>From Plant</th>
            <th>To Plant </th>
            <th>Drum Series</th>
            <th>Drum No.</th>    
            <th>Verify</th>
         </tr>
   </thead> 
   <tbody>
        <?php
        $sr=1;
            $sql="SELECT d.Challanno,d.id,d.Date,d.Name_of_contractor, d.Name,d.From_Plant
            ,d.To_Plant,d.Drum_series,d.Drum_No ,c.is_set FROM Dshift d left join Challan c on d.id=c.Dshift_id
            where d.Challanno='$challanno'and (d.Type='drums' or d.Type is null)     ";
            // $sql="select * from Dshift  where Challanno='$challanno' and Type='drums' ";
        
            $run=sqlsrv_query($conn,$sql);
      
            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){ 
                $is_set=$row['is_set'] ?? '';
        ?>
            <tr>
                <td><?php echo $sr ?></td>
                <td><input type="number" value="<?php echo $row['Challanno'] ?>"  name="challanno">
                    <input type="hidden" value="<?php echo $row['id'] ?>"  name="id[]"></td>
                <td><?php echo $row['Date']->format('d-m-Y')  ?></td>
                <td><?php echo $row['Name_of_contractor']  ?></td>
                <td><?php echo $row['Name']  ?></td>
                <td><?php echo $row['From_Plant']  ?></td>
                <td><?php echo $row['To_Plant']  ?></td>
                <td><?php echo $row['Drum_series']  ?></td>
                <td><?php echo $row['Drum_No']  ?></td>
                <td><input type="checkbox" class="verf" disabled >
                <input type="number" class="checkbox-state" name="checkbox_state[]" value="<?php echo $is_set ?>" ></td>
            </tr> 
        <?php 
        $sr++; }
        ?>  
   </tbody>
    
</table>
</form>
<script>
        $(document).ready(function(){
        // Event handler for the checkbox at the top
        $('#checkAll').change(function() {
            // Select all checkboxes in the rows and update their checked state
            $('.verf').prop('checked', $(this).prop('checked'));
            const isChecked = $(this).is(':checked');
            if (!isChecked) {
                $('.checkbox-state').val(0);
            } else {
                $('.checkbox-state').val(1);
            }
        });
    
//         $('.verf').change(function() {
//         const isChecked = $(this).is(':checked');
      
       
//             if (!isChecked) {
              
//                 $(this).closest('tr').find('.checkbox-state').val(0);
//             } else {
              
//                 $(this).closest('tr').find('.checkbox-state').val(1);
//             }

         
      
//     });
//     $(document).ready(function(){
    // Select all checkboxes with the class 'verf'
    const checkboxes = $('.verf');

    checkboxes.each(function() {
        // Find the corresponding hidden input for each checkbox
        const hiddenInput = $(this).closest('tr').find('.checkbox-state');
        
        // Check the checkbox based on the value of the hidden input
        if (hiddenInput.val() == 1) {
            $(this).prop('checked', true);
        }
    });
// });

    //    $(document).ready(function(){
        // Event handler for the checkbox at the top
        // $('#checkAll').change(function() {
        //     // Select all checkboxes in the rows and update their checked state
        //     $('.verf').prop('checked', $(this).prop('checked'));
        //     const isChecked = $(this).is(':checked');
        //     if (!isChecked) {
              
        //       $('.checkbox-state').val(0);
        //   } else {
            
        //       $('.checkbox-state').val(1);
        //   }

        // });

        var table = $('#challanmodaltab').DataTable({
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
