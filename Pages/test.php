<?php
include('../includes/dbcon.php');

if(isset($_POST['month'])){
    $month=$_POST['month'];
    $cont=$_POST['cont'];

    $m= date('m', strtotime($month));
    $year = date('Y', strtotime($month));
    $mon = date('F', strtotime("$month-01"));

?>
<div>
    <style>
         .fl{
            margin-top:2rem;
        }
          #summtable{
            table-layout: auto;
            width: 100%;

        }       
        #summtable input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        #summtable select{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        b{
            color:#1f9384;
        }
        .tqty{
            background-color:yellow !important;

        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        #summtable td{
            padding-left:0;
            padding-right:0;

        }
        .totcol{
            background-color:#d4d0cf !important;
        
        }
        .head{
            background-color:#f2f2f2; 

        }
        .abc{
            background-color:#e6e4e3 !important;
            font-weight:500;
        }
        .drums,.mat,.tname{
           cursor: pointer;
           text-decoration:none;    
           font-weight: normal; /* Remove the boldness */
           /* font-weight:1px !important; */
           color:black;
   
        }
        .roundoff{
            font-weight: normal;
        }
        .drums:hover,.mat:hover {
            color: black; /* Set the desired color for the hover state */
        }
      
        #purchase,#abc{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }
        .custom-modal{
            max-width: 70%;
        }
     
    </style>
    
    <table class="table table-bordered text-center" id="summtable">
        <tr class="head">
            <td class="text-center" colspan="5"><b> A. SHIFTING MATERIAL MONTH OF <?php echo date('F-Y',strtotime($month)) ?></b> </td>  
       </tr>
       <tr class="bg-secondary text-light">
            <th>DRUMS</th>
            <th>QTY</th>
            <th></th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
        $drums=array('A-SERIES','BL-SERIES','CL-SERIES','CR-SERIES','KCC-SERIES','ML-SERIES','VSM-SERIES','Wooden conductor  Drums');
        $sql10="SELECT name FROM  drum_series WHERE isDelete=0 ";
        $run10=sqlsrv_query($conn,$sql10);
        $row10=sqlsrv_fetch_array($run10,SQLSRV_FETCH_ASSOC);
       // $drums1=array('A','BL','CL','CR+AC','KRR','ML','VSM');
        $rate=array(40,25,25,40,40,25,25);
       for($i=0;$i<8;$i++){
        ?>
       <tr>
            <th>
                <input type="text" class="drums"  name="type[]" autocomplete="off" value="<?php echo $drums[$i]?>" readonly>
                <input type="hidden" class="ser" id="ser" value="<?php echo $row10['name']  ?>">
                <input type="hidden" name="mon" class="mon"  value="<?php echo $month ?>">
                <input type="hidden" name="cont" class="cont"  value="<?php echo $cont ?>">
                <input type="hidden" name="cat[]" class="cat"  value="Drum">
                <input type="hidden" name="remark[]" class="remark">
               
            </th>
            <?php 
            $sql="SELECT count(Drum_No) as cn FROM Dshift WHERE format(Date,'yyyy-MM')='$month' AND Drum_series='".$drums1[$i]."' "; 
            $run=sqlsrv_query($conn,$sql);
            $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
            ?>
          
            <td><input type="number" class="aqty" name="qty[]" value="<?php echo $row['cn'] ?>" autocomplete="off" ></td>
            <td><input type="number" class="afqty"  name="fqty[]" autocomplete="off" value='' readonly></td>
            <td><input type="number" class="arate"  name="rate[]" value="<?php echo $rate[$i]  ?>" ></td>
            <td><input type="number" class="aamt"  name="amt[]" value="<?php echo $rate[$i]*$row['cn']  ?>"readonly></td>
       </tr>
        <?php
        }  ?>
       <tr>
            <td></td>
            <td  class="totcol"><input type="number"  id="atqty" name="atqty" class="tqty" value="0" readonly></td>
            <td></td>
            <td></td>
            <td  class="totcol"><input type="number" id="atamt"  name="atamt" class="tamt" value="0" readonly></td>
       </tr> 
       <tr class="head"> 
             <td class="text-center "  colspan="5"> <b>B. SHIFTING MATERIAL MONTH OF <?php echo date('F-Y',strtotime($month)) ?></b> </td>  
        </tr>

       <tr class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php   
        $material=array('PVC COMPOUND 1701 TO 2205','PVC COMPOUND ( IN PLANT )','GI / ALU WIRE (Double)','GI WIRE (IN PLANT)','RM ShiftingS RAPPING'); 
        $rate2=[65,65,80,80,80];

        for($i=0;$i<5;$i++){ ?>
        <tr>
            <th><input type="text" class="bmat"  name="type[]" autocomplete="off" value="<?php echo $material[$i]?>">
                <input type="hidden" name="cat[]" class="cat"  value="RM_Shifting">
                <input type="hidden" name="remark[]"  class="remark">
            </th>
            <td><input type="number" class="bqty"  name="qty[]" autocomplete="off"></td>
            <td><input type="number" class="bfqty"  name="fqty[]" autocomplete="off"></td>
            <td><input type="number" class="brate"  name="rate[]" value="<?php echo $rate2[$i]  ?>" ></td>
            <td><input type="number" class="bamt"  name="amt[]" readonly></td>
        </tr>
       <?php 
        }
      
        for($i=0;$i<5;$i++){ ?>
        <tr>
            <th>
                <input type="text" class="bmat"  name="type[]" autocomplete="off" >
                <input type="hidden" name="cat[]" class="cat" value="RM_Shifting">
                <input type="hidden" name="remark[]"  class="remark">
            </th>
            <td><input type="number" class="bqty"  name="qty[]" autocomplete="off"></td>
            <td><input type="number" class="bfqty"  name="fqty[]" autocomplete="off"></td>     
            <td><input type="number" class="brate"  name="rate[]" ></td>
            <td><input type="number" class="bamt"  name="amt[]" readonly></td>
        </tr>
        <?php  }
        ?>
        <tr>
            <td colspan="2"></td>
            <td class="totcol"><input type="number"  id="btqty" name="btqty" class="tqty" value="0" readonly></td>
            <td></td>
            <td  class="totcol"><input type="number" id="btamt" name="btamt" class="tamt1" value="0" ></td>
        </tr> 
        <tr class="head">
            <td class="text-center "  colspan="5"><b>PURCHASE MATERIALS (UNLOADING) MONTH OF <?php echo date('F-Y',strtotime($month)) ?> .</b> </td>  
        </tr>
        <tr class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
      $pmaterial = ['PVC COMPOUND', 'GI WIRE', 'PVC COMPOUND(Rejection Unloading)', 'Roundoff'];
      $rate1=[65,80,65,65];
      for ($i = 0; $i < 4; $i++) {
      ?>
          <tr>
              <th>
                  <?php if ($i==3) { ?>
                    <input type="text"   name="type[]" autocomplete="off" value="<?php echo $pmaterial[$i]?>" readonly>
                    <!-- <span class="roundoff"  name="type[]"><?php echo $pmaterial[$i] ?></span> -->
                     
                  <?php } else { ?>
                    <input type="text" class="mat"  name="type[]" autocomplete="off" value="<?php echo $pmaterial[$i]?>" readonly>
                    <!-- <a class="mat"  name="type[]"><?php echo $pmaterial[$i] ?></a> -->
                  <?php } ?>
                  <input type="hidden" class="pmaterial" value="<?php echo $pmaterial[$i] ?>">
                  <input type="hidden" class="ser"  value="<?php echo $drums[$i] ?>">
                  <input type="hidden" name="cat[]" class="cat"  value="Purchase_Unloading">
                  <input type="hidden" name="remark[]"  class="remark">
              </th>  
            <?php
               if( $pmaterial[$i]=='Roundoff'){
                ?>
                <td>
                    <input type="number" class="cqty"  name="qty[]" autocomplete="off" >
                </td>
            <?php
            }else{
                    $sql7="select DISTINCT(tqty) from purchase_data  where main_grade='".$pmaterial[$i]."' AND month='$month' and is_cancel= 0 ";
                    $run7=sqlsrv_query($conn,$sql7);
                    $row7=sqlsrv_fetch_array($run7,SQLSRV_FETCH_ASSOC);
            ?>
                <td>
                    <input type="number"  step="0.1" class="cqty"  name="qty[]"  value="<?php echo $row7['tqty']/1000 ?>"  readonly>
                </td>
            <?php
               }
            ?>
                <!-- <input type="number" class="cqty"  step="0.01  " id="cqty<?php echo $i; ?>" name="qty[]" autocomplete="off" value='0'> -->
                
              <td><input type="number" class="cfqty"  name="fqty[]" autocomplete="off" readonly></td>
              <td><input type="number" class="crate"  name="rate[]" value="<?php echo $rate1[$i] ?>" readonly></td>
              <td><input type="number"  step="0.1" class="camt"  name="amt[]" value="<?php echo ($row7['tqty']/1000)*$rate[$i] ?>"></td>
          </tr>
      <?php
      }
      ?>
        <tr>
            <td ></td>
            <td class="totcol"><input type="number"  id="ctqty" name="ctqty" class="ctqty" value="0" readonly></td>
            <td colspan="2"></td>
            <td class="totcol"><input type="number"   step="0.1" id="ctamt" name="ctamt" class="tamt2" value="0" readonly></td>
       </tr> 
       <tr>
            <td class="abc" colspan="4">TOTAL=PURCHASE+SHIFTING</td>
            <td style="background-color:#d9d9d9"><input type="number" step="0.01" name="total" id="total" class="total" value="0" ></td>
        </tr>
        <tr class="head"> <TH colspan="5"><b>SUMMARY MONTH OF <?php echo date('F-Y',strtotime($month)) ?>(JOB WORK BILL)</b></TH>
        </tr>
        <tr class="bg-secondary text-light">
            <th colspan="2">TEAM NAME</th>
            <th colspan="2">REMARK</th>
            <th>AMOUNT</th>
        </tr>
        <?php
        $sql8="select name from scrap_team where isDelete=0";
        $run8=sqlsrv_query($conn,$sql8);
        $i=1;
        while($row8=sqlsrv_fetch_array($run8,SQLSRV_FETCH_ASSOC)) {
        //$teamname=array('RAMSAWARE','NATU MAKHWANA','DILIP CHAVDA','KETAN VAGHELA','HARI RAM SUTHAR','OTHERS');
        // for($i=0;$i<6;$i++){
            ?>
        <tr>
            <td colspan="2">
                <input type="text" name="type[]"  class="tname" autocomplete="off"  value="<?php echo $row8['name'] ?>">
              
                <input type="hidden" name="cat[]" class="cat"  value="Scrap">        
            </td>
            <td colspan="2"><input type="text" name="remark[]"  class="remark"></td>

            <?php
            if($i==1){
            ?>
            <td><input type="number" step="0.01" name="amt[]" id="tamount" class="tamount" value="0" ></td>
            <?php
            }else{

                $sql9="SELECT sum(distinct (Totalamt)) as sum FROM scraphead h left outer join scrapdetail t on h.id=t.head_id 
                where h.Teamname='".$row8['name']."' AND h.Month='$mon' AND FORMAT(H.Fromdate,'yyyy')='$year'";
                $run9=sqlsrv_query($conn,$sql9);
                $row9=sqlsrv_fetch_array($run9,SQLSRV_FETCH_ASSOC);
           
                ?>
                    <td><input type="number" name="amt[]" class="tamount" value="<?php echo $row9['sum']?>" ></td>
                <!-- <td><input type="number" name="amt[]" class="tamount" ></td> -->
                <?php
            }
            ?>
        </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td class="abc" colspan="2"> GRAND TOTAL</td>
            <td class="totcol"><input step="0.01" type="number" name="grandtotal" id="grandtotal" class="grandtotal">  </td>
        </tr>
        </table>
    <div class="row mb-3 mt-5">
        <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="save" form="summform" >Save</button></div>
        <div class="col-auto p-0 "> <a type="" class="btn  rounded-pill btn-secondary " href="summary.php">Back</a></div>     
    </div>
<?php
}
?> 
<script>
    //for drum modal
    $(document).on('click','.drums',function(){
        // Find the closest parent row of the clicked "drums" element
            // var row = $(this).closest('tr');
            // // Find the "ser" input within the same row
            // var ser = row.find('#ser').val();
            var ser= $('.ser').val();
            console.log(ser);
          
            var mon= $('.mon').val();
        
            $.ajax({
                url:'summary_drum_modal.php',
                type: 'post',
                data: {mon:mon,ser:ser},  
                // dataType: 'json',
                success:function(data){
                $('#drum_table').html(data);  
                $('#summdrum').modal('show');
                }
            });
            });

            
    //for material modal
    $(document).on('click','.mat',function(){
            // Find the closest parent row of the clicked "drums" element
            var row = $(this).closest('tr');
            // Find the "ser" input within the same row
            var pmat = row.find('.pmaterial').val();   
            var mon= $('.mon').val();
            var selectedPmat = pmat;
            $.ajax({
                url:'summary_pmat_modal.php',
                type: 'post',
                data: {mon:mon,pmat:pmat},  
                // dataType: 'json',
                success:function(data)
                {
                $('#bbb').html(data);  
                $('#pmat').modal('show');
                }
            });

            $(document).on('click','.completed',function()
            {

            var mon= $('.mon').val();
            var id = $('#temp').val();
                
                $.ajax({
                    url:'summary_pmatcomp_modal.php',
                    type: 'post',
                    data: {mon:mon,pmat:selectedPmat,id:id},  
                    // dataType: 'json',
                    success:function(data)
                    {
                        $('#bbb').html(data);  
                    //$('#pmat').modal('show');
                    }
                });
                });

        $(document).on('click','.add',function(){

        var mon= $('.mon').val();
        
    
        $.ajax({
            url:'summary_pmatadd_modal.php',
            type: 'post',
            data: {mon:mon,pmat:selectedPmat},  
            // dataType: 'json',
            success:function(data){
            $('#add').html(data);  
            $('#secondModal').modal('show');
            }
        });
        });
    });
    
    // Attach a click event to the "Completed" button
    $(document).on('click', '.completed', function() {

        var saveButton = $('.modal-footer .save');
        saveButton.text("Update");
        saveButton.removeClass("save").addClass("update");
        saveButton.attr("name", "updateButton");
        saveButton.attr("id", "updateButton");
    });
    // Function to reset the button to "Save"
    function resetSaveButton() {

        var saveButton = $('.modal-footer .update');
        saveButton.text("Save");
        saveButton.removeClass("update").addClass("save");
        saveButton.attr("name", "purchaseform");
        saveButton.attr("id", "purchaseform");
    }

    // Listen for the modal hidden event
    $('#pmat').on('hidden.bs.modal', function() {
        resetSaveButton(); // Call the function to reset the button
    });

 
  
    //for calculating amount for A.shifting material
    // tamt,1,2
    //aqty
    //bfqty
    //cfqty
    $(document).on("change",".aqty,.arate",function(){
        var amt = 0;
        var totalSum=0;
        var rate = $(this).closest('tr').find('.arate').val();
        var qty = $(this).closest('tr').find('.aqty').val(); 
        $(this).closest('tr').find('.aamt').val(rate*qty);

        $('.aqty').each(function () {
                const value = parseFloat($(this).val());
               
                if(!isNaN(value)) {
                    totalSum += value;
                } 
            });
            $('#atqty').val(totalSum);

        $('.aamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
         
        $(".tamt").val(amt);   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#tamount").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });
    
      // Calculate and display the total sum for AMOUNT and QTY when the page loads
      $(document).ready(function() {
        let totalSumQty = 0;
        let totalSumAmt = 0;
        
        // Calculate the total sum for AMOUNT and QTY
        $('.aqty').each(function() {
            const qty = parseFloat($(this).val());
            const rate = parseFloat($(this).closest('tr').find('.arate').val());
            
            if (!isNaN(qty) && !isNaN(rate)) {
                const amt = qty * rate;
                totalSumQty += qty;
                totalSumAmt += amt;
            }
        });

        // Display the total sum for QTY and AMOUNT
        $('#atqty').val(totalSumQty);
        $('#atamt').val(totalSumAmt);
         // You can choose to display the total in any field you prefer.
    });
   
    $(document).on("change",".bfqty,.brate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.brate').val();
        var qty = $(this).closest('tr').find('.bfqty').val(); 
        $(this).closest('tr').find('.bamt').val(rate*qty);

        $('.bfqty').each(function () {
                const value = parseFloat($(this).val());
             
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
        // Display the total sum
        $('#btqty').val(totalSum);

        $('.bamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
       
        $(".tamt1").val(amt);   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#tamount").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });

    $(document).on("change",".cqty",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.crate').val();
        var qty = $(this).closest('tr').find('.cqty').val(); 
        $(this).closest('tr').find('.camt').val((rate*qty).toFixed(2));

        $('.cqty').each(function () {
                const value = parseFloat($(this).val());
               
                if (!isNaN(value)) {
                    totalSum += value;
                 } 
            });
         
            $('#ctqty').val(totalSum);

        $('.camt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
      
           $(".tamt2").val(amt.toFixed(2));
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#tamount").val((tamt1 + tamt2 + tamt3).toFixed(2));
        
    
    });
    
    // Calculate and display the total sum for AMOUNT and QTY when the page loads
    $(document).ready(function() {
        let totalSumQty = 0;
        let totalSumAmt = 0;
        
        // Calculate the total sum for AMOUNT and QTY
        $('.cqty').each(function() {
            const qty = parseFloat($(this).val());
            const rate = parseFloat($(this).closest('tr').find('.crate').val());
            
            if (!isNaN(qty) && !isNaN(rate)) {
                const amt = qty * rate;
                totalSumQty += qty;
                totalSumAmt += amt;
            }
        });

        // Display the total sum for QTY and AMOUNT
        $('#ctqty').val(totalSumQty.toFixed(2));
        $('#ctamt').val(totalSumAmt.toFixed(2));
            // You can choose to display the total in any field you prefer.
    });

    $(document).ready(function() {
        
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#tamount").val((tamt1 + tamt2 + tamt3).toFixed(2));
        $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
        //$("#tamount").val((tamt1 + tamt2 + tamt3).toFixed(2));
    });
    
    // for total amt in summary month of 2023-03
     $(document).on('change','.tamount',function(){
            let totalSum = 0;
         
            $('.tamount').each(function () {
                const value = parseFloat($(this).val());
               
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#grandtotal').val(totalSum.toFixed(2));

         });
    //modal for summary      
     $(document).on('click','.tname',function(){
        // Find the closest parent row of the clicked "drums" element
        var tname=$(this).val();
        var mon= $('.mon').val();
        
        $.ajax({
            url:'summary_tname_modal.php',
            type: 'post',
            data: {mon:mon,tname:tname},  
            // dataType: 'json',
            success:function(data){
              $('#abc').html(data);  
              $('#summodal').modal('show');
            }
          });
        });


</script>