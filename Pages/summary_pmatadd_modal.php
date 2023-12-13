<?php
include('../includes/dbcon.php');
$mon=$_POST['mon'];
$pmat=$_POST['pmat'];
?>
<!-- <div class="total">
    <h5 >Total Qty:</h5> <h5><input type="number" id="tqty" name="tqty"> </h5>
</div> -->
<!-- <form action="summary_db.php" method="post" id="secondform" autocomplete="off" enctype="multipart/form-data"> -->
    <form id="addform">
    <table class="table table-bordered text-center table-striped table-hover mt-7" id="pmattable">
        <tr class="bg-secondary text-light">
            <th>Sr</th>
            <th>Rev Date</th>
            <th>Inv No.</th>
            <th>Inv Date.</th>
            <th>Party</th>
            <th>Item</th>
            <th>Pkg</th>
            <th>Qnty</th>
            <th>Rate</th>
            <th>Basic Amt</th>
        
        <tr>
            <?php 
            //   $sql7="select DISTINCT(tqty) as tqty from purchase_data  where main_grade='$pmat' AND month='$mon' and is_cancel=0 ";
           // $sql7="select distinct(tqty) as t from purchase_data where is_cancel=0 and main_grade='$pmat' and month='$mon' ";
            //  $sql7="SELECT COALESCE((DISTINCT tqty), 0) AS t
            //  from purchase_data where is_cancel=0 and main_grade='$pmat' and month='$mon' ";   
            $sql7 = "SELECT DISTINCT tqty as t
            FROM purchase_data
            WHERE main_grade = '$pmat' AND month = '$mon' AND is_cancel = 0
            UNION ALL
            SELECT 0
            WHERE NOT EXISTS (SELECT 1 FROM purchase_data WHERE main_grade = '$pmat' AND month = '$mon' AND is_cancel = 0);
           ";
   
              $run7=sqlsrv_query($conn,$sql7);
              $row7=sqlsrv_fetch_array($run7,SQLSRV_FETCH_ASSOC);   ?>

 

            <td><?php echo 1  ?>
            <input type="hidden" class="inw_id" name="inw_id" value="0" ></td>
            <input type="hidden" class="main_grad" name="main_grad" value="<?php echo $pmat ?>" >
            <input type="hidden" class="mon" id="mon" name="mon" value="<?php echo $mon ?>" >
            <input type="hidden" id="t" name="tqty" value="<?php echo $row7['t']   ?>">
            <td>
                <input type="date" name="recdate" id="recdate" class="recdate" required 
                min="<?php echo $mon ?>-01" 
                max="<?php echo $mon ?>-<?php echo date('t',strtotime($mon)); ?>">
            </td>
            <td><input type="number" name="invno" id="invno" class="invno" required></td>
            <td><input type="date" name="invdate" id="invdate" class="invdate" required></td>
            <td><input type="number" name="partyn" id="partyn" class="partyn" required></td>
            <td><input type="number" name="item" id="item" class="item" required></td>
            <td><input type="number"  name="pkg" id="pkg" class="pkg" required></td>
            <td><input type="number" id="qty2" class="qty2" name="qty" required></td>
            <td><input type="number" id="rate" class="rate" name="rate" required> </td>
            <td><input type="number"  id="amt" class="amt" name="amt" required></td>
        </tr>
   </table>
</form>
   <script>

$(document).on("change",".qty2,.rate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.rate').val();
        var qty = $(this).closest('tr').find('.qty2').val(); 
        $(this).closest('tr').find('.amt').val(rate*qty);

});



   </script>