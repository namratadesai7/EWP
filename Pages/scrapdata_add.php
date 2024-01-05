<?php
include('../includes/dbcon.php');
include('../includes/header.php');  

$sql="SELECT MAX(Challanno) AS ch FROM Dshift";
$run=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Scrap Data</title>

    <style>
        .fl{
            margin-top:2rem;
        }
        form label{
            width:20%;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        .col-lg-3{
            padding: 0px 4px;
        }

        #scrapTable{
            table-layout: auto;
            width: 100%;

        }       
        #scrapTable input,#scrapTable select{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
            padding:0px !important;
            margin:0px !important;

        }
        /* input{
            padding:0px !important;
            margin:0px !important;
        } */
    </style>
</head>
<body>
    <div class="container-fluid fl">
        
        <form action="scrapdata_db.php" method="post" autocomplete="off">
            <div class="row mb-3">
                <div class="col"><h4 class="pt-2 mb-0">Add Scrap data</h4></div>
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn" onclick="checkdate(this)" name="save" >Save</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="scrapdata.php">Back</a></div>
            </div>

            <div class="divCss">
                <div class="row px-2">
                    <label class="form-label col-lg-3 col-md-6" for="wscale">Weight Scale
                        <select  class="form-select wscale" name="wscale" id="wscale" required>
                            <option disabled selected value="">--Select--</option>
                            <option value="1">Weight Scale-1</option>
                            <option value="2">Weight Scale-2</option>
                            <option value="3">Weight Scale-3</option>
                            <option value="4">Weight Scale-4</option>
                            <option value="5">Weight Scale-5</option>
                        </select>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="fdate">From Date
                        <input class="form-control fdate" type="date" id="fdate" name="fdate" onchange="checkDateSelection()" required >      
                        <p id="alert"  style="color:red;"></p>  
                        <input type="hidden" id="maxdate">                
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="tdate">To Date
                        <input class="form-control tdate" type="date" id="tdate" name="tdate" onchange="checkDateSelection()"required >
                        <p id="alertMessage" style="color: red;"></p>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="month">Month
                        <input class="form-control" type="text" id="month" name="month" value=""  readonly required>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="stype">Type of Scrap
                        <select  class="form-select stype" name="stype" id="stype" required>
                            <option disabled selected value="">--Select--</option>
                            <option value="CP">Control/Power</option>
                            <option value="IP">Instru/Panni</option>
                            <option value="OE">Other Extra</option>
                            <option value="RO">R-Outer</option>
                        </select>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="tname">Team Name
                        <select  class="form-select" name="tname" id="tname" required>
                            <option disabled selected value="">--Select--</option>
                            <?php
                            $sql1="SELECT name FROM scrap_team";
                            $run1=sqlsrv_query($conn,$sql1);
                            while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                            <option value="<?php echo $row1['name'] ?>" ><?php echo $row1['name'] ?></option>
                          <?php } ?>
                        </select>
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="mp">M.P
                        <input class="form-control" type="number" id="mp" name="mp" value="0" >
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="twt">Total WT
                        <input class="form-control twt" type="number" id="twt" name="twt" value="0"  readonly >
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="tamt">Total Amount 
                        <input class="form-control" type="number" id="tamt" name="tamt" value="0" readonly  >
                    </label>
                   <div id="showrec"></div>
                   
                </div>

                <div class="row mb-3">              
                    <div class="col ms-2"> <button type="button"  id="addRowBtn" class="btn  rounded-pill btn-danger mt-2"  >Add</button></div>                
                </div>    
                <div id="showdata">
                    <!-- <table  class="table table-bordered text-center mb-0" id="scrapTable" >
                        <thead class="bg-secondary text-light">
                            <th>Type</th>
                            <th>Name</th>
                            <th>Remark</th>
                            <th>Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>   
                            <th></th>                  
                        </thead>
                        <tbody>                  
                            <?php                          
                            $name=array('Bare Cu','Tin Cu','Alu','PVC','XLPE','GI','Tape','PVC-D(RE-OUT)');
                            $name1=array('bare_cu','tin_cu','alu','pvc','xlpe','gi','tape_r','pvc_d');
                            // $rate=array('6','6','5','3','3','2','0','2');
                            $qty=array();
                            for($i=0;$i<8;$i++){                
                            ?>
                            <tr>                    
                                <td><input type="text"  name="type[]" value="Regular"></td>
                                <td><input  class="name" type="text"  name="name[]" value="<?php echo $name[$i]   ?>"></td>
                                <td><input type="text"  class="rem" name="rem[]" ></td>
                                <td><input step="0.01" class="qty" type="number"  name="qty[]"></td>
                                <td><input  class="rate" type="number"  name="rate[]" > </td>
                                <td><input class="amt" type="number" name="amt[]"  readonly></td>
                                <td></td>
                            </tr>
                            <?php
                            }                      
                            ?>                      
                        </tbody>
                    </table>   -->
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php

include('../includes/footer.php');

?>
<script>

        $('#sdata').addClass('active');

        function checkdate(button){ 
            console.log("test")
            var fromdate = $('#fdate').val();
            var todate = $('#tdate').val();
            var mindate=$('#maxdate').val();


            var fromDateObj = new Date(fromdate);
                var mindateObj = new Date(mindate);

            if ( fromDateObj<= mindateObj) {
                console.log("sds")
                alert("From Date must be greater than '" + mindate);
                event.preventDefault(); // Prevent form submission
            } 



        }

        $(document).on("click", ".datechange", function () {
            // Traverse the DOM to find the parent row
            var alert = document.getElementById("alert");
            alert.textContent = " "; 
            var fromdate = $(this).attr('id');
            var todate = $(this).data('todate');
            $('#fdate').val(fromdate);
            $('#tdate').val(todate);

            $('#fdate').prop('readonly', true);
            $('#tdate').prop('readonly', true);

            var fdate = $('#fdate').val();
            var tdate = $('#tdate').val();
            var wscale=$('#wscale').val();
            var month=$('#month').val();
         
    
            if (fdate!='' && tdate!='' && wscale!=''  && wscale!=null) {
         
                // Check if the record already exists in the database
                $.ajax({
                    url: 'scrap_check_record.php', // Create a new PHP file for checking if the record exists
                    type: 'post',
                    data: {
                        fdate: fdate,
                        tdate: tdate,
                        wscale:wscale
                    },
                    success: function (data) {
                        if (data === "exists") {
                            // If the record exists, redirect to the edit page for that record
                            window.location.href = 'scrapdata_edit.php?param1=' + fdate + '&param2=' + tdate + '&param3=' + wscale;
                         //   window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;
                        } else {
                            // If the record doesn't exist, load the form for adding a new record
                           // window.location.href = 'scrapdata_add.php';    
                            
                           console.log(data)                    
                        }
                    },
                    error: function (res) {
                    }
                });
                }

        });

        $(document).on("change", ".fdate,.tdate,.wscale", function () {
            var fdate = $('#fdate').val();
            var tdate = $('#tdate').val();
            var wscale=$('#wscale').val();
            var month=$('#month').val();
            var fromDateObj = new Date(fdate);
               
    
            if (fdate!='' && tdate!='' && wscale!=''  && wscale!=null) {
         
                // Check if the record already exists in the database
                $.ajax({
                    url: 'scrap_check_record.php', // Create a new PHP file for checking if the record exists
                    type: 'post',
                    data: {
                        fdate: fdate,
                        tdate: tdate,
                        wscale:wscale
                    },
                    success: function (data) {
                        if (data === "exists") {
                            // If the record exists, redirect to the edit page for that record
                            window.location.href = 'scrapdata_edit.php?param1=' + fdate + '&param2=' + tdate + '&param3=' + wscale;
                         //   window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;
                        } else {
                            // If the record doesn't exist, load the form for adding a new record
                           // window.location.href = 'scrapdata_add.php';    
                            
                           console.log(data)                    
                        }
                    },
                    error: function (res) {
                    }
                });
                }
                else{
                    if(month!='' &&  wscale!=''  && wscale!=null ){
                        var alert = document.getElementById("alert");
                    
                        $.ajax({
                            url: 'scrap_check_record1.php', // Create a new PHP file for checking if the record exists
                            type: 'post',
                            dataType: "json",
                            data: {mon:month,ws:wscale},
                            success: function (data) {
                                var tableData = data.tableData;

                                // Access count value
                                var t = data.t;
                               
                               
                                $('#showrec').html(data.table);
                                 if(t!=''){
                                  
                                //     // Adding one day to the date 't'
                                    var tDate = new Date(t);

                                    // tDate.setDate(tDate.getDate() + 1);

                                //     // Format the new date as 'yyyy-MM-dd'
                                    var newFdate = tDate.toISOString().split('T')[0];
                                //         if ( fromDateObj<= tDate) {
                                //             alert.textContent = "'From Date must be greater than '" + t; 
                                //             document.getElementById('fdate').setAttribute("min", newFdate);
                                //         } 

                                //     // Set the new date to the fdate input
                                 $('#maxdate').val(newFdate);
                                   

                                 }
                                // else{
                                //     alert.textContent = " "; 
                                //      $('#fdate').val(newFdate );

                                // }
                              
                            },
                            error: function (res) {
                                console.log(res);
                            }
                        });
                    }
                }
        });
      
  
        $(document).on('focusout','.qty',function(){
            let totalSum = 0;
            let totalAmt = 0;
            $('.qty').each(function () {
                const value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#twt').val(totalSum.toFixed(2));

            $('.amt').each(function () {
                const value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    totalAmt += value;
                } 
            });
            // Display the total sum
            $('#tamt').val(totalAmt.toFixed(2));
        });

        //for calculating amount
        $(document).on("change",".qty,.rate",function(){
            var rate = $(this).closest('tr').find('.rate').val();
            var qty = $(this).closest('tr').find('.qty').val(); 
            $(this).closest('tr').find('.amt').val((rate*qty).toFixed(2));  
        });      
 
        $('#fdate').on('change', function () {
            const selectedDate = $(this).val();
            const dateParts = selectedDate.split('-'); // Assuming date format is YYYY-MM-DD

            if (dateParts.length === 3) {
                const year = parseInt(dateParts[0]);
                const month = parseInt(dateParts[1]);
                const day = parseInt(dateParts[2]);

                // Check if the date is valid
                if (!isNaN(year) && !isNaN(month) && !isNaN(day)) {
                    // Create a Date object and set the selected date
                    const date = new Date(year, month - 1, day); // Month is 0-based, so subtract 1

                    // Get the full month name
                    const fullMonthName = date.toLocaleString('default', { month: 'long' });

                    // Set the full month name in the #month input
                    $('#month').val(fullMonthName);
                } else {
                    // Handle invalid date input
                    $('#month').val('');
                }
            } else {
                // Handle invalid date input
                $('#month').val('');
            }
        });

        // function checkDateSelection() {
        //     var fromDate = document.getElementById("fdate").value;
        //     var toDate = document.getElementById("tdate").value;
        //     var alertMessage = document.getElementById("alertMessage"); 
        //     var alert = document.getElementById("alert");
                   

        //     if (fromDate === "" || toDate === "") {
        //         alertMessage.textContent = "'To Date' must be grater than 'From Date'";         
        //     } 
        //     else {
        //         alertMessage.textContent = "";
        //         alert.textContent = " ";
        //     }
        // }
        function checkDateSelection() {
            var fromDate = document.getElementById("fdate").value;
            var toDate = document.getElementById("tdate").value;
            var alertMessage = document.getElementById("alertMessage"); 
            var alert = document.getElementById("alert");

        
                var fromDateObj = new Date(fromDate);
                var toDateObj = new Date(toDate);

                if (toDateObj <= fromDateObj) {
                    alertMessage.textContent = "'To Date' must be greater than 'From Date'";
                } else {
                    alertMessage.textContent = "";
                   
                }
            }
     

        $(document).ready(function() {
            // Event listener for "Add" button
            $('#addRowBtn').on('click', function() {
                // Get a reference to the tbody of the table
                const tbody = $('#scrapTable tbody');

                // Create a new row and append it to the tbody
                const newRow = $('<tr>');
                newRow.html(' <td><input  type="text" class="type" name="type[]" value="Other"></td> <td> <select class="name" name="name[]" required><option  disabled selected value="">--Select--</option><option value="other">Other</option></option><option value="Bare Cu">Bare Cu</option><option value="Tin Cu">Tin Cu</option><option value="Alu">Alu</option><option value="PVC">PVC</option><option value="XLPE">XLPE</option><option value="GI">GI</option><option value="Tape">Tape</option><option value="PVC-D(RE-OUT)">PVC-D(RE-OUT)</option></select></td> <td><input type="text" class="rem" name="rem[]"></td> <td><input class="qty" step="0.01" type="number" name="qty[]"></td> <td><input step="0.01" class="rate" type="number" name="rate[]" value="0"></td> <td><input class="amt" type="number" name="amt[]" readonly></td>,<td><button class="btn-sm btn-danger remove-row" >X</button></td>');

                // Append the new row to the table
                tbody.append(newRow);

                // Add an event listener for input changes in the new row
                newRow.find('.qty, .rate').on('input', function() {
                    updateRowAmount(newRow);
                });

                // Add an event listener to the delete button
                newRow.find('.remove-row').on('click', function() {
                    deductRowValues(newRow);
                    newRow.remove(); // Remove the row when the button is clicked
                });
            });

            // Function to update the amount for a row
            function updateRowAmount(row){
            let totalAmt = 0;
            const qty = parseFloat(row.find('.qty').val());
            const rate = parseFloat(row.find('.rate').val());
            const amt = isNaN(qty) || isNaN(rate) ? 0 : qty * rate;
            row.find('.amt').val(amt.toFixed(2));
            
            $('.amt').each(function() {
                const value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    totalAmt += value;
                }
            });
            // Display the total sum
            $('#tamt').val(totalAmt.toFixed(2));
            }

            // Function to deduct the values when a row is removed
            function deductRowValues(row) {
            const amt = parseFloat(row.find('.amt').val()) || 0;
            const qty = parseFloat(row.find('.qty').val()) || 0;
            const currentTwt = parseFloat($('#twt').val()) || 0;
            const currentTamt = parseFloat($('#tamt').val()) || 0;

            // Update twt and tamt by subtracting the amount from the row being removed
            $('#twt').val(currentTwt - qty);
            $('#tamt').val(currentTamt - amt);
            }

            // Event listener for scrap type selection
            $('#stype').on('change', function() {
                var stype = $('#stype').val();
            

                let totalSum = 0;
                let totalAmt = 0;

                if(stype=='RO'){

                    $.ajax({
                    url: 'scrapdata_detail.php',
                    type: 'post',

                    data: {
                        stype1: stype
                    },
                    success: function(data) {
                       
                        $('#showdata').html(data);
                    },
                     error: function(res) {
                            console.log(res);
                        }

                    })
                }else{
                 
                    $.ajax({
                        url: 'scrapdata_detail.php',
                        type: 'post',

                        data: {
                            stype1: stype
                        },
                        success: function(data) {
                       
                            $('#showdata').html(data);
                            var stype = $('#stype').val();

                            $.ajax({
                                url: 'scrapdata_detail.php',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    stype: stype
                                },

                                success: function(data) {

                                    $('.rate').each(function(index) {
                                        var $rateInput = $(this);
                                    
                                        if (index < 8) {
                                            $rateInput.val(data[index]);
                                        }

                                        if ((stype === 'CP' || stype === 'IP')&& index < 8) {
                                            $rateInput.prop('readonly', true);
                                        } else {
                                            $rateInput.prop('readonly', false);
                                        }
                                    });

                                    // Recalculate row amounts
                                    // $('.qty, .rate').trigger('input');

                                    $('.qty').each(function () {
                                        //const value = parseFloat($(this).val());
                                        const qty = parseFloat(($(this).val() == '') ? 0 : $(this).val());
                                        const rate = parseFloat(($(this).closest('tr').find('.rate').val() == '') ? 0 : $(this).closest('tr').find('.rate').val());
                                     
                                            totalSum += qty;
                                            const amt = qty * rate;
                                            $(this).closest('tr').find('.amt').val(amt.toFixed(2));
                                    });
                                    // Display the total sum
                                    $('#twt').val(totalSum.toFixed(2));

                                    $('.amt').each(function () {
                                        const value = parseFloat($(this).val());
                                        if (!isNaN(value)) {
                                            totalAmt += value;
                                        } 
                                        });
                                    // Display the total sum
                                    $('#tamt').val(totalAmt.toFixed(2));
                                },
                                error: function(res) {
                                        console.log(res);
                                }
                    });
                        },
                        error: function(res) {
                                console.log(res);
                            }

                    })
          
   
                }
            });
        });
        
   // disable dates
    var today= new Date();
    var last = new Date();
    last.setDate(today.getDate() - 30);

        var d = today.getDate();
        var m = today.getMonth() +1;
        var y = today.getFullYear();
     
        if(d<10){   
        d='0'+d;
        }
        if(m<10){
        m='0'+ m;
        }
        today = y+ '-' + m + '-' + d ;
        last = last.toISOString().split('T')[0];

        document.getElementById('fdate').setAttribute("max", today);
        document.getElementById('fdate').setAttribute("min", last);

        document.getElementById('tdate').setAttribute("max", today);
        document.getElementById('tdate').setAttribute("min", last);
 
</script>

