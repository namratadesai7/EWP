<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
  
$id=$_GET['edit'] ?? '';
$fdate=$_GET['param1']?? '';
$tdate=$_GET['param2'] ?? '';
$wscale=$_GET['param3'] ?? '';

if($id!=''){
    $sql="SELECT id,Typeofscrap,format(Fromdate,'yyyy-MM-dd') as fdate,format(Todate,'yyyy-MM-dd') as tdate,Month,Teamname,mp,Totalwt,Totalamt,wt_scale FROM scraphead WHERE id='$id' ";
    $sql2="SELECT * FROM scrapdetail WHERE head_id ='$id'";
}else{
    $sql="SELECT id,Typeofscrap,format(Fromdate,'yyyy-MM-dd'),Todate,Month,Teamname,mp,Totalwt,Totalamt,wt_scale FROM scraphead WHERE Fromdate='$fdate' and Todate='$tdate' and wt_scale='$wscale'";
    $sql2="SELECT * FROM scrapdetail WHERE head_id in(select id from scraphead where Fromdate='$fdate' and Todate='$tdate' and wt_scale=$wscale )";
}
$run=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scrapdata</title>
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
        }
        
    </style>
</head>
<body>
<div class="container-fluid fl">
        
        <form action="scrapdata_db.php" method="post" autocomplete="off">
            <div class="row mb-3">
                <div class="col"><h4 class="pt-2 mb-0">Edit Scrap data</h4></div>
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="update" >Update</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="scrapdata.php">Back</a></div>
            </div>

            <div class="divCss">
                <div class="row px-2">

                    <label class="form-label col-lg-3 col-md-6" for="wscale">Weight Scale
                        <?php
                        $row['wt_scale']=$row['wt_scale'] ?? $wscale; 
                        ?>
                        <select  class="form-select wscale" name="wscale" id="wscale" required>
                            <option disabled selected value="">--Select--</option>
                            <option <?php if($row['wt_scale']==1) { ?> selected <?php } ?> value="1">Weight Scale-1</option>
                            <option <?php if($row['wt_scale']==2) { ?> selected <?php } ?> value="2">Weight Scale-2</option>
                            <option <?php if($row['wt_scale']==3) { ?> selected <?php } ?>  value="3">Weight Scale-3</option>
                            <option <?php if($row['wt_scale']==4) { ?> selected <?php } ?> value="4">Weight Scale-4</option>
                            <option <?php if($row['wt_scale']==5) { ?> selected <?php } ?> value="5">Weight Scale-5</option>
                        </select>
                    </label> 

                    <label class="form-label col-lg-3 col-md-6" for="fdate">From Date
                        <?php
                        $row['fdate']=$row['fdate']  ?? $fdate;
                        ?>
                        <input class="form-control" type="date" id="fdate" name="fdate" onchange="checkDateSelection()" value="<?php echo $row['fdate']  ?>"  required >
                        <input type="hidden" name="id" id="id"  value="<?php echo $row['id'] ?? 'empty' ?>" >
                        
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="tdate">To Date
                        <?php 
                         $row['tdate']=$row['tdate']?? $tdate;
                         ?>
                        <input class="form-control" type="date" id="tdate" name="tdate" onchange="checkDateSelection()" value="<?php echo $row['tdate'] ?>" required >
                        <p id="alertMessage" style="color: red;"></p>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="month">Month
                        <input class="form-control" type="text" id="month" name="month" value="<?php echo $row['Month'] ?? '' ?>" readonly required>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="stype">Type of Scrap
                        <select  class="form-select" name="stype" id="stype" value="<?php echo $row['Typeofscrap']  ?? '' ?>"required>
                            <option disabled selected value="">--Select--</option>
                            <option <?php if($row['Typeofscrap']?? '' =="CP") {?> selected <?php } ?> value="CP" >Control/Power</option>
                            <option <?php if($row['Typeofscrap']?? '' =="IP") {?> selected <?php } ?> value="IP" >Instru/Panni</option>
                            <option <?php if($row['Typeofscrap']?? '' =="OE") {?> selected <?php } ?> value="OE" >Other Extra</option>
                            <option <?php if($row['Typeofscrap']?? '' =="RO") {?> selected <?php } ?> value="RO" >R-Outer</option>
                        </select>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="tname">Team Name
                        <select  class="form-select" name="tname" id="tname" value="<?php echo $row['Teamname'] ?? '' ?>"  required>
                            <option disabled selected value="">--Select--</option>
                            <?php
                            $sql1="SELECT name FROM scrap_team";
                            $run1=sqlsrv_query($conn,$sql1);
                            while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                            <option <?php if($row['Teamname'] ?? ''==$row1['name']) { ?> selected <?php } ?> > <?php echo $row1['name'] ?> </option>
                            <?php
                            } ?>  
                        </select>
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="mp">M.P
                        <input class="form-control" type="number" id="mp" name="mp" value="<?php echo $row['mp'] ?? '' ?>"  >
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="twt">Total WT
                        <input class="form-control twt" type="number" id="twt" name="twt" value="<?php echo $row['Totalwt']?? '' ?>"  readonly >
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="tamt">Total Amount
                        <input class="form-control" type="number" id="tamt" name="tamt" value="<?php echo $row['Totalamt']?? '' ?>" readonly  >
                    </label>

                <div id="showrec">
                <?php
                if($fdate==''){

                }else{
                    ?>
                    <table class="table table-bordered text-center mb-0">
                        <thead>
                            <th>Ws</th>
                            <th>Fdate</th>
                            <th>Tdate</th>
                            <th>View</th>
                        </thead>
                        <tbody>                                                                                                                                                                           
                            <tr>
                            <?php
                            $sr=1;
                            $timestamp = strtotime($fdate);
                            $mon=date('F',$timestamp);
                                $sql1=" SELECT wt_scale,Fromdate,Todate from scraphead where Month='$mon' and wt_scale='$wscale' ";
                                $run1=sqlsrv_query($conn,$sql1);              
                                while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                            <td><?php echo $row1['wt_scale'] ?></td>
                            <td><?php echo $row1['Fromdate']->format('Y-m-d')  ?></td>
                            <td><?php echo $row1['Todate']->format('Y-m-d')  ?> </td>
                            <td><button class="btn btn-sm rounded-pill btn-warning"  onclick="datechange(this)"  id="<?php echo $row2['cn'] ?>"
                            data-name="<?php echo $row2['t'] ?>" > View</button></td>
                            </tr>
                            <?php 
                            $sr++;
                                }
                                ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>    
                </div>
                </div>
                <div class="row mb-3">              
                    <div class="col ms-2"> <button type="button"  id="addRowBtn" class="btn  rounded-pill btn-danger mt-2" >Add</button></div>                
                </div>    
                <div id="showdata">                          
                    <table  class="table table-bordered text-center mb-0" id="scrapTable" >
                        <thead>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Remark</th>
                            <th>Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>   
                            <th></th>                  
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                               
                                $run2=sqlsrv_query($conn,$sql2);
                                while($row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
                                    ?>                       
                                <td>
                                    <input type="hidden" name="detailSr[]" value="<?php echo $row2['id'] ?? '' ?>">
                                    <input type="text" id="type" class="type" name="type[]" value="<?php echo $row2['Type'] ?? '' ?>">
                                </td>
                                <td><input class="name" type="text"  name="name[]" value="<?php echo $row2['Name'] ?? '' ?>"></td>
                                <td><input type="text" class="rem" name="rem[]" value="<?php echo $row2['Remark'] ?? '' ?>"></td>
                                <td><input step="0.01" class="qty" type="number"  name="qty[]" value="<?php echo $row2['qnty'] ?? '' ?>"></td>
                                <td><input step="0.01" class="rate" type="number"  name="rate[]" value="<?php echo $row2['rate'] ?? ''   ?>"> </td>
                                <td><input class="amt" type="number" name="amt[]" value="<?php echo $row2['amount'] ?? '' ?>" readonly></td>       
                                <td></td>                    
                                <?php                          
                                ?>
                            </tr>
                            <?php
                                }              
                            ?>                      
                        </tbody>
                    </table>
                </div>    
            </div>
        </form>
    </div>
</body>
</html>
<script>
    $('#sdata').addClass('active');

    function datechange(button) {
        // Traverse the DOM to find the parent row
        var row = $(button).closest('tr');
        var wtscale=row.find('td:nth-child(1)').text().trim();
        var fromdateString = row.find('td:nth-child(2)').text().trim();
        var todateString = row.find('td:nth-child(3)').text().trim();

        var cn = $(button).attr('id');
        var t = $(button).data('name');

        $('#fdate').val(fromdateString)
        $('#tdate').val(todateString);

        var fdate = $('#fdate').val();
        var tdate = $('#tdate').val();
        var wscale=$('#wscale').val();
        console.log(fdate,tdate,wscale);

        // console.log(month);
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
                        window.location.href = 'scrapdata_edit.php?param1=' + fdate + '&param2=' + tdate + '&param3=' + wscale;                                          
                    }
                    var mon=$('#month').val();
                   
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }else{
            console.log("empty")
        }
    }

    
    $(document).on("change", ".fdate,.tdate,.wscale", function () {
        var fdate = $('#fdate').val();
        var tdate = $('#tdate').val();
        var wscale=$('#wscale').val();
        console.log(fdate,tdate,wscale);


        // console.log(month);
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
                        window.location.href = 'scrapdata_edit.php?param1=' + fdate + '&param2=' + tdate + '&param3=' + wscale;                                          
                    }
                    var mon=$('#month').val();
                   
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }else{
            console.log("empty")
        }
    }); 
            
    //readonly for type regular and editable rate for type='other'                     
    $(document).ready(function () {
        $('.type').each(function () {
        const sel =$(this).val();
       
        if(sel =='Regular'){
            $(this).closest('tr').find('.rate').prop('readonly', true);
      
        }else{
            $(this).closest('tr').find('.rate').prop('readonly', false);
        }

        });
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

    function checkDateSelection() {
        var fromDate = document.getElementById("fdate").value;
        var toDate = document.getElementById("tdate").value;
        var alertMessage = document.getElementById("alertMessage");
        
        if (fromDate === "" || toDate === "") {
            alertMessage.textContent = "'To Date' must be grater than 'From Date'";
            
        } 
        else {
            alertMessage.textContent = "";
            
        }
    }
    $(document).ready(function() {
        //add extra row at end of table
        // Add an event listener to the "Add" button
        $('#addRowBtn').on('click', function () {
        // Get a reference to the tbody of the table
        const tbody = $('#scrapTable tbody');

        // Create a new row and append it to the tbody
        const newRow = $('<tr>');
        newRow.html(' <td><input type="text" class="type" id="type" name="type[]" value="Other"></td> <td> <select class="name" id="name[]" name="name[]"  required><option  disabled selected value="">--Select--</option><option value="other">Other</option><option value="Bare Cu">Bare Cu</option><option value="Tin Cu">Tin Cu</option><option value="Alu">Alu</option><option value="PVC">PVC</option><option value="XLPE">XLPE</option><option value="GI">GI</option><option value="Tape">Tape</option><option value="PVC-D(RE-OUT)">PVC-D(RE-OUT)</option></select></td> <td><input type="text" class="rem" name="rem[]"  ></td> <td><input class="qty" type="number" step="0.01"  name="qty[]"></td> <td><input class="rate" step="0.01" type="number"  name="rate[]" value="0" ></td> <td><input step="0.01" class="amt" type="number"  name="amt[]"></td>,<td><button class="btn-sm btn-danger remove-row" >X</button></button></td>');

        // Append the new row to the table
        tbody.append(newRow);

        // Add an event listener for input changes in the new row
        newRow.find('.qty, .rate').on('input', function () {
            updateRowAmount(newRow);
        });
         // Add an event listener to the delete button
        newRow.find('.remove-row').on('click', function () {
            deductRowValues(newRow);
            newRow.remove(); // Remove the row when the button is clicked
        });
    });

    // Function to update the amount for a row
    function updateRowAmount(row) {
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

    //disable dates
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

    //month fetch
    $(document).ready(function ()  {
        const selectedDate = $('#fdate').val();
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
</script>