<?php
include('../includes/dbcon.php');
include('../includes/header.php');  

$date=date("Y-m-d");
$id=$_GET['edit'];

$sql="SELECT * from Oshift where id='$id' ";
$run=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Other Shifting data</title>

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
        
        <form action="Oshift_db.php" method="post" autocomplete="off">
            <div class="row mb-3">
                <div class="col"><h4 class="pt-2 mb-0">Add Other Shifting data</h4></div>
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="update" >Update</button></div>
                <div class="col-auto p-0"> <a class="btn  rounded-pill btn-secondary " href="othershift.php">Back</a></div>
            </div>

            <div class="divCss">
                <div class="row px-2">
                    

                    <label class="form-label col-lg-3 col-md-6" for="fdate">Date
                        <input class="form-control fdate" type="date" id="fdate" name="fdate" value="<?php echo $row['Date']->format('Y-m-d') ?>" required >      
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="month">Month
                        <input class="form-control" type="text" id="month" name="month" value="<?php echo $row['Month'] ?>"  readonly required>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="stype">Type
                        <select  class="form-select stype" name="stype" id="stype" required>
                            <option disabled selected value="">--Select--</option>
                            <?php
                            $sql1="SELECT workdet FROM other_work where isDelete='0'";
                            $run1=sqlsrv_query($conn,$sql1);
                            while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                              <option <?php if($row['Type']==$row1['workdet']){ ?> selected <?php }?>   ><?php echo $row1['workdet'] ?></option>
                        
                        <?php } ?>
                        </select>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="tname">Team Name
                        <select  class="form-select tname" name="tname" id="tname" required>
                            <option disabled selected value="">--Select--</option>
                            <?php
                            $sql1="SELECT name FROM scrap_team";
                            $run1=sqlsrv_query($conn,$sql1);
                            while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                            <option <?php if($row['Teamname']==$row1['name']){ ?> selected <?php }?>   ><?php echo $row1['name'] ?></option>
                          <?php } ?>
                        </select>
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="mp">M.P
                        <input class="form-control" type="text" id="mp" name="mp" value="0" value="<?php echo $row['mp'] ?>" >
                    </label>

                    
                    <label  class="form-label col-lg-3 col-md-6" for="work">Work
                        <input class="form-control" type="text" id="work" name="work"  value="<?php echo $row['workdet'] ?>"  >
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="twt">Total WT/Qty
                        <input class="form-control twt" type="number" id="twt" name="twt"  value="<?php echo $row['Totalwt'] ?>"  >
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="rate">Rate
                        <input class="form-control rate" type="number" id="rate" name="rate" value="<?php echo $row['Rate'] ?>"      >
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="tamt">Total Amount 
                        <input class="form-control tamt" type="number" id="tamt" name="tamt"  value="<?php echo $row['Amount'] ?>" readonly  >
                    </label>
                

            </div>
        </form>
    </div>
</body>
</html>

<?php

include('../includes/footer.php');

?>
<script>

        $('#oshift').addClass('active');

        $(document).on('change','#stype',function(){
            var stype=$(this).val();
            var qty = $('.twt').val();
            $.ajax({
                url: 'Oshift_db.php',
                        type: 'post',
                        data: {
                            stype1: stype
                        },
                        success: function(data) {
                            $('#rate').val(data);
                            var rate = $('.rate').val();
                            
            $('.tamt').val((rate*qty).toFixed(2)); 
                        },
                        error:function(data){
                            console.log(data);
                        }  
            })
         })
       
        //for calculating amount
        $(document).on("change",".stype,.twt,.rate",function(){
            console.log("sd")
            var rate = $('.rate').val();
            var qty = $('.twt').val();

            $('.tamt').val((rate*qty).toFixed(2));  
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


  
        
   
 
</script>

