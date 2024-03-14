<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
$contractor=$_GET['param1'];
$month=$_GET['param2'];
$mon = date('F', strtotime("$month-01"));
$year = date('Y', strtotime("$month-01"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entery</title>

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
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
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
        /* #summtable th{
            padding-left:0;
        } */
        #summtable td{
            padding-left:0;
            padding-right:0;

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
        #drum_table{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }
        #bbb,#abc{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }
        .custom-modal{
            max-width: 70%;
        }
            
    </style>
</head>
<body>
    <div class="container fl">
        
        <form action="summary_db.php" method="post" >
        <table class="table table-bordered text-center" id="summtable">
        
        <tr class="head">
            <td class="text-center" colspan="5"><b> A. SHIFTING MATERIAL MONTH OF <?php  echo date('F-Y',strtotime($month)) ?></b> </td>  
       </tr>
       <tr  class="bg-secondary text-light">
            <th>DRUMS</th>
            <th>QTY</th>
            <th></th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
        $sql="SELECT DISTINCT(total_qnty),total_amt,CAT,type,qnty,rate,amt,id FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='Drum' AND isdelete=0";
        $run=sqlsrv_query($conn,$sql);
        while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
            $tqty=$row['total_qnty'];
            $tamt=$row['total_amt'];
            ?>
       <tr>
            <th>        
                <input type="text" class="drums"  name="type[]" autocomplete="off" value="<?php echo $row['type'] ?>" readonly>
                <input type="hidden" name="mon" class="mon"  value="<?php echo $month ?>">
                <input type="hidden" name="cont" class="cont" id="cont" value="<?php echo $contractor ?>">
                <input type="hidden" name="cat[]" class="cat" id="cat[]" value=<?php echo $row['CAT'] ?>>
                <input type="hidden" name="id[]" class="id" id="id" value=<?php echo $row['id']   ?>>
                <input type="hidden" name="remark[]" id="remark[]" class="remark">
            </th>
            <td><input type="number" class="aqty"  name="qty[]" autocomplete="off" value="<?php echo $row['qnty'] ?>" ></td>
            <td><input type="number" class="afqty"  name="fqty[]" autocomplete="off" value='' readonly></td>
            <td><input type="number" class="arate" name="rate[]"  value="<?php echo $row['rate']  ?>" ></td>
            <td><input type="number" class="aamt"  name="amt[]"  value="<?php echo $row['amt']  ?>" readonly></td>
       </tr>
       <?php
        }
       
        ?>
       <tr >
            <td></td>
            <td class="totcol"><input type="number"  id="atqty" name="atqty" class="tqty" value="<?php echo $tqty ?>" readonly></td>
            <td></td>
            <td></td>
            <td class="totcol"><input type="number" id="atamt"  name="atamt" class="tamt" value="<?php echo $tamt ?>"readonly></td>
       </tr> 
       
       <!-- modal -->
       <div class="modal fade" id="summdrum" tabindex="-1" aria-labelledby="summdrum" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-xl">
                        <h5 class="modal-title">Show Series</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-xl">
                        <div id="drum_table">

                        </div>
                        <!-- <form action="addpos_db.php" method="post" id="editForm" autocomplete="off" enctype="multipart/form-data">

                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary" name="edit" form="editForm">Save</button> -->
                    </div>
                </div>
            </div>
        </div>

        <tr class="head"> 
             <td class="text-center"  colspan="5"> <b>B. SHIFTING(OTHERS) MATERIAL MONTH OF <?php  echo date('F-Y',strtotime($month))  ?></b> </td>  
        </tr>
       <tr  class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
        $sql9="SELECT DISTINCT(total_qnty),total_amt,CAT,type,qnty,rate,amt,final_qnty,id  FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='others' AND isdelete=0";
        $run9=sqlsrv_query($conn,$sql9);
       
        while($row9=sqlsrv_fetch_array($run9,SQLSRV_FETCH_ASSOC)){
            $btqty=$row9['total_qnty'];
            $btamt=$row9['total_amt'];
    ?>
            <th>
                <input type="text" class="dmat"  name="type[]" autocomplete="off" value="<?php echo $row9['type']?>">
                <input type="hidden" name="cat[]" class="cat"  value=<?php  echo $row9['CAT'] ?>>
                <input type="hidden" name="id[]" class="id"  value=<?php echo $row9['id']   ?>>
                <input type="hidden" name="remark[]"  class="remark">
            </th>
            <td><input type="number" class="dqty" name="qty[]" step="0.01" value="<?php echo $row9['qnty'] ?>" autocomplete="off"></td>
            <td><input type="number" class="dfqty"  name="fqty[]"  step="0.01"  value="<?php echo $row9['final_qnty'] ?>"></td>
            <td><input type="number" class="drate"  name="rate[]" step="0.01"  value="<?php echo $row9['rate'] ?>" ></td>
            <td><input type="number" class="damt"  name="amt[]" step="0.01"  value="<?php echo $row9['amt']    ?>"></td>
        </tr>
       <?php  }
      $run20=sqlsrv_query($conn,$sql9);
      $row20=sqlsrv_fetch_array($run20,SQLSRV_FETCH_ASSOC);
    ?>
        <tr >
            <td colspan="2"></td>
            <td class="totcol"> <input type="number"  id="dtqty" name="dtqty" class="tqty"  readonly></td>
            <td></td>
            <td class="totcol"><input type="number" id="dtamt" name="dtamt" class="tamt3"  readonly></td>
        </tr> 


       <tr class="head"> 
             <td class="text-center"  colspan="5"> <b>B. SHIFTING MATERIAL MONTH OF <?php  echo date('F-Y',strtotime($month))  ?></b> </td>  
        </tr>
       <tr  class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
        $sql2="SELECT DISTINCT(total_qnty),total_amt,CAT,type,qnty,rate,amt,final_qnty,id  FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='RM_Shifting' AND isdelete=0";
        $run2=sqlsrv_query($conn,$sql2);
       
        while($row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
            $btqty=$row2['total_qnty'];
            $btamt=$row2['total_amt'];
    ?>
            <th>
                <input type="text" class="bmat"  name="type[]" autocomplete="off" value="<?php echo $row2['type']?>">
                <input type="hidden" name="cat[]" class="cat"  value=<?php  echo $row2['CAT'] ?>>
                <input type="hidden" name="id[]" class="id"  value=<?php echo $row2['id']   ?>>
                <input type="hidden" name="remark[]"  class="remark">
            </th>
            <td><input type="number" class="bqty" name="qty[]" step="0.01" value="<?php echo $row2['qnty'] ?>" autocomplete="off"></td>
            <td><input type="number" class="bfqty"  name="fqty[]"  step="0.01"  value="<?php echo $row2['final_qnty'] ?>"></td>
            <td><input type="number" class="brate"  name="rate[]" step="0.01"  value="<?php echo $row2['rate'] ?>" ></td>
            <td><input type="number" class="bamt"  name="amt[]" step="0.01"  value="<?php echo $row2['amt']    ?>"></td>
        </tr>
       <?php  }
      
?>
        <tr >
            <td colspan="2"></td>
            <td class="totcol"> <input type="number"  id="btqty" name="btqty" class="tqty" value="<?php echo $btqty ?>" readonly></td>
            <td></td>
            <td class="totcol"><input type="number" id="btamt" name="btamt" class="tamt1" value="<?php echo $btamt ?>" readonly></td>
        </tr> 

        <tr class="head"> 
             <td class="text-center"  colspan="5"> <b>C. OTHER SHIFTING & MANPOWER MONTH OF <?php  echo date('F-Y',strtotime($month))  ?></b> </td>  
        </tr>
       <tr  class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
        $sql9="SELECT DISTINCT(total_qnty),total_amt,CAT,type,qnty,rate,amt,final_qnty,id  FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='Manpower' AND isdelete=0";
        $run9=sqlsrv_query($conn,$sql9);
       
        while($row9=sqlsrv_fetch_array($run9,SQLSRV_FETCH_ASSOC)){
            $etqty=$row9['total_qnty'];
            $etamt=$row9['total_amt'];
    ?>
            <th>
                <input type="text" class="emat"  name="type[]" autocomplete="off" value="<?php echo $row9['type']?>">
                <input type="hidden" name="cat[]" class="cat"  value=<?php  echo $row9['CAT'] ?>>
                <input type="hidden" name="id[]" class="id"  value=<?php echo $row9['id']   ?>>
                <input type="hidden" name="remark[]"  class="remark">
            </th>
            <td><input type="number" class="eqty" name="qty[]" step="0.01" value="<?php echo $row9['qnty'] ?>" autocomplete="off"></td>
            <td><input type="number" class="efqty"  name="fqty[]"  step="0.01"  value="<?php echo $row9['final_qnty'] ?>"></td>
            <td><input type="number" class="erate"  name="rate[]" step="0.01"  value="<?php echo $row9['rate'] ?>" ></td>
            <td><input type="number" class="eamt"  name="amt[]" step="0.01"  value="<?php echo $row9['amt']    ?>"></td>
        </tr>
       <?php  }
      
    ?>
        <tr >
            <td colspan="2"></td>
            <td class="totcol"> <input type="number"  id="etqty" step="0.01" name="etqty" class="tqty" value="<?php echo $etqty ?>" readonly></td>
            <td></td>
            <td class="totcol"><input type="number" id="etamt" step="0.01" name="etamt" class="tamt4" value="<?php echo $etamt ?>" readonly></td>
        </tr> 
 

        <tr class="head">
            <td class="text-center"  colspan="5"><b>PURCHASE MATERIALS (UNLOADING) MONTH OF <?php  echo date('F-Y',strtotime($month))  ?> </b> </td>  
        </tr>
        <tr  class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
       $unique_id_counter = 1;
          $sql4="SELECT * FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='Purchase_Unloading' AND isdelete=0";
          $run4=sqlsrv_query($conn,$sql4);
         while($row4=sqlsrv_fetch_array($run4,SQLSRV_FETCH_ASSOC)){
            $ctqty=$row4['total_qnty'];
            $ctamt=$row4['total_amt'];
            $unique_id = 'cqty' . $unique_id_counter;  
           ?>
        <tr>
            <th>
            <?php
             if( $row4['type']=="Roundoff"){ ?>
                <input type="text"   name="type[]" autocomplete="off" value="Roundoff" readonly>
            <?php
             } else{
                ?>
                <input type="text" class="mat"  name="type[]" autocomplete="off" value="<?php echo $row4['type']   ?>" >
                <?php
             }
             ?>          
              <input type="hidden" name="cat[]" class="cat"  value=<?php  echo $row4['CAT'] ?>>
                <input type="hidden" name="id[]" class="id"  value=<?php echo $row4['id']   ?>>
                <input type="hidden" name="remark[]"  class="remark">
            </th>

            <?php
               if( $row4['type']=='Roundoff'){
                ?>
                <td>
                <input type="number" class="cqty"  name="qty[]" autocomplete="off" value="<?php echo $row4['qnty']    ?>" >
                </td>
            <?php   
            }else{

                    $sql7="select DISTINCT(tqty) from purchase_data  where main_grade='".$row4['type']."' AND month='$month' and is_cancel=0 ";    
                    $run7=sqlsrv_query($conn,$sql7);
                    $row7=sqlsrv_fetch_array($run7,SQLSRV_FETCH_ASSOC);
                   $abc= $row7['tqty']??'';
                   if($abc!=''){
                    $abc=$abc/1000;
                   }
            ?>
                  <td><input type="number"  step="0.1" class="cqty"  name="qty[]" autocomplete="off" value="<?php echo $abc  ?>"  readonly></td>
            <?php
               }
            ?>

            <!-- <td><input type="number" step="0.01" class="cqty"  id="<?php echo $unique_id; ?>"name="qty[]" value="<?php echo $row4['qnty']   ?>" autocomplete="off"></td> -->
            <td><input type="number"  class="cfqty"  name="fqty[]" value="<?php echo $row4['final_qnty']   ?>" autocomplete="off" readonly></td>
            <td><input type="number" class="crate"  name="rate[]" value="<?php echo $row4['rate']   ?>" <?php if( $row4['type']!='Roundoff'){ ?>readonly <?php } ?>></td>
            <td><input type="number" step="0.01" class="camt"  name="amt[]"></td>
        </tr>
            <?php
             $unique_id_counter++;
         }
         $sql5="SELECT distinct(total_qnty),total_amt,grand_total FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='Purchase_Unloading' AND isdelete=0";
         $run5=sqlsrv_query($conn,$sql5);
         $row5=sqlsrv_fetch_array($run5,SQLSRV_FETCH_ASSOC);
         ?>
          <tr>
            <td ></td>
            <td class="totcol"><input type="number"   id="ctqty" name="ctqty" class="ctqty"  readonly></td>
            <td colspan="2"></td>
         
            <td class="totcol"><input type="number"   id="ctamt" name="ctamt" class="tamt2" value="0" readonly></td>
       </tr> 
        <!-- <tr >
            <td ></td>
            <td class="totcol"><input type="number" step="0.01"  id="ctqty" name="ctqty" class="ctqty" value="<?php echo $ctqty ?>" readonly></td>
            <td colspan="2"></td>
         
            <td class="totcol"><input type="number"  step="0.1" id="ctamt" name="ctamt" class="tamt2" value="<?php echo round($ctamt,2)  ?>" readonly></td>
       </tr>  -->
           <!-- modal -->         
        <div class="modal fade" id="pmat" tabindex="-1" aria-labelledby="pmat" aria-hidden="true">
            <div class="modal-dialog custom-modal">
                <div class="modal-content">
                <div class="modal-header ">
                        <h5 class="modal-title">Purchase </h5>
                            <button type="button" class=" btn rounded-pill common-btn completed ms-4 me-2">Completed</button> 
                            <button type="button" class="btn rounded-pill common-btn add" >Add</button>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                    </div>
                    <div class="modal-body">
                       
                       <div id="bbb">

                       </div>
                    </div>
                    <div class="modal-footer">
                    
                    <button type="button" class=" btn rounded-pill bg-secondary text-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn rounded-pill common-btn save" name="purchaseform" form="purchaseform"  id="purchaseform">Save</button>
                    </div>
                </div>
            </div>
        </div>
          <!-- Second Modal for for rm software -->
          <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="secondModalLabel" aria-hidden="true">
            <div class="modal-dialog custom-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="add">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-pill common-btn" name="secondform" id="secondform">Save</button>
                    </div>
                </div>
            </div>
        </div>
       <tr>
            <td class="abc" colspan="4">TOTAL=PURCHASE+SHIFTING</td>
            <!-- <td style="background-color:#d9d9d9"> <input type="number" name="total" id="total" class="total" value=""></td> -->
            <!-- <?   $abc= $row['total_amt']+$row2['total_amt']+$row4['total_amt']; ?> -->
            <td style="background-color:#d9d9d9"> <input type="number" step="0.01"  name="total" id="total" class="total" ></td>
        </tr>
        <tr class="head"> <TH colspan="5"><b>SUMMARY MONTH OF <?php echo date('F-Y',strtotime($month))    ?> (JOB WORK BILL)</b></TH>
        </tr>
        <tr  class="bg-secondary text-light">
            <th colspan="2">TEAM NAME</th>
            <th colspan="2">REMARK</th>
            <th>AMOUNT</th>
        </tr>
        <?php
        $sql6="SELECT * FROM summary WHERE contrator='$contractor' AND month='$month' AND CAT='Scrap' AND isdelete=0";
        $run6=sqlsrv_query($conn,$sql6);
        $i=1;
       while($row6=sqlsrv_fetch_array($run6,SQLSRV_FETCH_ASSOC)){
  
        $gtotal=$row6['grand_total'];
        
            ?>
        <tr>
            <td colspan="2"><input type="text" name="type[]"  class="tname" value="<?php echo $row6['type'] ?>"  readonly> 
            <input type="hidden" name="cat[]" class="cat"  value="<?php  echo $row6['CAT'] ?>" >
            <input type="hidden" name="id[]" class="id"  value="<?php echo $row6['id']   ?>" >
            </td>
            <td colspan="2"><input type="text" name="remark[]" class="remark" value="<?php echo $row6['remark'] ?>" ></td>
            <?php
            if($i==1){
            ?>
            <td><input type="number" name="amt[]" id="tamount" class="tamount" step="0.01" value="<?php echo $row6['amt'] ?>" ></td>
            <?php
           
       
            }else{            
            //     $sql8="SELECT sum(distinct (Totalamt)) as sum FROM scraphead h left outer join scrapdetail t on h.id=t.head_id 
            //     where h.Teamname='".$row6['type']."' AND h.Month='$mon' AND FORMAT(H.Fromdate,'yyyy')='$year'";
            //    // echo $sql7 .'<br>';
            //     $run8=sqlsrv_query($conn,$sql8);
            //     $row8=sqlsrv_fetch_array($run8,SQLSRV_FETCH_ASSOC);
               
            ?>
           <!-- <td><input type="number" name="amt[]" class="tamount" value="<?php echo $row8['sum']?>" ></td> -->
                  <td><input type="number" name="amt[]" class="tamount" value="<?php echo $row6['amt'] ?>" ></td>
            <?php 
            }
            ?>
        </tr>
            <?php
         
           $i= $i+1; 
        }
        ?>
        <tr >
            <td colspan="2"></td>
            <td class="abc" colspan="2" >GRAND TOTAL</td>
            <td class="totcol"> <input step="0.01" type="number" name="grandtotal" id="grandtotal" class="grandtotal" value="<?php echo $gtotal ?>" >  </td>
        </tr>
        <!-- summary modal -->
        <div class="modal fade" id="summodal" tabindex="-1" aria-labelledby="summodal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-xl">
                        <h5 class="modal-title">Show Series</h5> 
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">  
                        <div id="abc">

                        </div>            
                        <!-- <form action="summary_db.php" method="post" id="purchaseform" autocomplete="off" enctype="multipart/form-data">
                        <
                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" btn rounded-pill bg-secondary text-light" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn rounded-pill common-btn save" name="purchaseform" form="purchaseform">Save</button> -->
                    </div>
                </div>
            </div>
        </div>
       
    </table>
    <div class="row mb-3 mt-5">
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="update" >Update</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="summary.php">Back</a></div>
    </div>
</form>
 </div>
</body>
</html>

<?php
include('../includes/footer.php');
?>
<script>
    $('#summary').addClass('active');
   
    $(document).ready(function() {

        $(document).on('click','#purchaseform', function(){
            $.ajax({                                  
                url:'summary_purchase_db.php',
                type:'post',
                data:$('#purchase').serialize(),       
                                                    
                success:function(response){          
                console.log(response);        
                var month = $('.mon').val();
                var cont = $('#cont').val();
                window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;                            
                                                                    
                alert("Saved Successfully"); 
                $('#pmat').modal('hide');
                
            }
        })
        });

        $(document).on('click','#updateButton', function(){
         
            $.ajax({                                 
                url:'summary_purchasecomp1_db.php',
                type:'post',
                data:$('#purcomplete').serialize(),       
                                                     
                success:function(response){        
                 
                console.log(response);    
                var month = $('.mon').val();
                var cont = $('#cont').val();
                window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;
        
                alert( "Updated Successfully"); 
                $('#pmat').modal('hide');

            },
            error:function(abc){
                console.log(abc);
            }
        })
        });

        $(document).on('click','#secondform', function(){
            $.ajax({                                    
                url:'summary_purchasecomp_db.php',
                type:'post',
                data:$('#addform').serialize(),       
                                                        
                success:function(response){  
                        
                console.log(response);    
                
                var month = $('.mon').val();
                var cont = $('#cont').val();
                window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;

                alert(response); 
           
                $('#secondModal').modal('hide');
                //$('#pmat').modal('hide');
            },
            error:function(abc){
                console.log(abc);
            }
        })
        });
    });

    //for drum modal
    $(document).on('click','.drums',function(){
        var ser = $(this).val();
        var result = ser.substring(0, ser.indexOf('-'));
        var mon= $('.mon').val();
        console.log(mon);
        console.log(result);
     
        $.ajax({
            url:'summary_drum_modal.php',
            type: 'post',
            data: {mon:mon,ser:result},  
            // dataType: 'json',
            success:function(data){
              $('#drum_table').html(data);  
              $('#summdrum').modal('show');
            }
          });
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
               
                if (!isNaN(value)) {
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
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        console.log(tamt1, tamt2, tamt4);

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);

        let totalSum1 = 0;
        
        $('.tamount').each(function () {
            const value = parseFloat($(this).val());
            
            if (!isNaN(value)) {
                totalSum1 += value;
            } 
        });
        // Display the total sum
        $('#grandtotal').val(totalSum1.toFixed(2));
      //  $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });

    $(document).on("change",".dfqty,.drate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.drate').val();
        var qty = $(this).closest('tr').find('.dfqty').val(); 
        $(this).closest('tr').find('.damt').val((rate*qty).toFixed(2));

        $('.dfqty').each(function () {
                const value = parseFloat($(this).val());
             
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#dtqty').val(totalSum.toFixed(2));

        $('.damt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
         
        $(".tamt3").val(amt.toFixed(2));   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        console.log(tamt1, tamt2, tamt4);

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);

        let totalSum1 = 0;
        
        $('.tamount').each(function () {
            const value = parseFloat($(this).val());
            
            if (!isNaN(value)) {
                totalSum1 += value;
            } 
        });
        // Display the total sum
        $('#grandtotal').val(totalSum1.toFixed(2));
       // $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });
    
    $(document).on("change",".bfqty,.brate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.brate').val();
        var qty = $(this).closest('tr').find('.bfqty').val(); 
        $(this).closest('tr').find('.bamt').val((rate*qty).toFixed(2));

        $('.bfqty').each(function () {
                const value = parseFloat($(this).val());
             
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#btqty').val(totalSum.toFixed(2));

        $('.bamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
         
        $(".tamt1").val(amt.toFixed(2));   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        console.log(tamt1, tamt2, tamt4);

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);

        let totalSum1 = 0;
        
        $('.tamount').each(function () {
            const value = parseFloat($(this).val());
            
            if (!isNaN(value)) {
                totalSum1 += value;
            } 
        });
        // Display the total sum
        $('#grandtotal').val(totalSum1.toFixed(2));
       // $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });
     //manpower
     $(document).on("change",".efqty,.erate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.erate').val();
        var qty = $(this).closest('tr').find('.efqty').val(); 
        $(this).closest('tr').find('.eamt').val((rate*qty).toFixed(2));

        $('.efqty').each(function () {
                const value = parseFloat($(this).val());
             
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#etqty').val((totalSum).toFixed(2));

        $('.eamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
         
        $(".tamt4").val((amt).toFixed(2));   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        console.log(tamt1, tamt2, tamt4);

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);


        let totalSum1 = 0;
        
        $('.tamount').each(function () {
            const value = parseFloat($(this).val());
            
            if (!isNaN(value)) {
                totalSum1 += value;
            } 
        });
        // Display the total sum
        $('#grandtotal').val(totalSum1.toFixed(2));
       // $("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });

    $(document).on("change",".cqty,.crate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.crate').val();
        var qty = $(this).closest('tr').find('.cqty').val(); 
        $(this).closest('tr').find('.camt').val((rate*qty));

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
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        console.log(tamt1, tamt2, tamt4);

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);

        let totalSum1 = 0;
        
        $('.tamount').each(function () {
            const value = parseFloat($(this).val());
            
            if (!isNaN(value)) {
                totalSum1 += value;
            } 
        });
        // Display the total sum
        $('#grandtotal').val(totalSum1.toFixed(2));
        //$("#grandtotal").val((tamt1 + tamt2 + tamt3).toFixed(2));
    
    });

    $(document).ready(function() {
        let totalSumQty = 0;
        let totalSumAmt = 0;
        
        // Calculate the total sum for AMOUNT and QTY
        $('.cqty').each(function() {
            const qty = parseFloat($(this).val());
            const rate = parseFloat($(this).closest('tr').find('.crate').val());
          
            
            if(!isNaN(qty) && !isNaN(rate)) {
                const amt = qty * rate;
                $(this).closest('tr').find('.camt').val(amt.toFixed(2));
                totalSumQty += qty;
                totalSumAmt += amt;
            }
        });

        // Display the total sum for QTY and AMOUNT
        $('#ctqty').val((totalSumQty).toFixed(2));
        $('#ctamt').val((totalSumAmt).toFixed(2));
            // You can choose to display the total in any field you prefer.      
    });

    $(document).ready(function() {
        
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        var tamt4 = parseFloat($(".tamt3").val());
        var tamt5 = parseFloat($(".tamt4").val());

        // Replace NaN values with 0
        tamt1 = isNaN(tamt1) ? 0 : tamt1;
        tamt2 = isNaN(tamt2) ? 0 : tamt2;
        tamt3 = isNaN(tamt3) ? 0 : tamt3;
        tamt4 = isNaN(tamt4) ? 0 : tamt4;
        tamt5 = isNaN(tamt5) ? 0 : tamt5;

        // Perform the calculation
        var totalAmount = (tamt1 + tamt2 + tamt3 + tamt4+tamt5).toFixed(2);
        $(".total").val(totalAmount);
        $("#tamount").val(totalAmount);

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
 
    // for total amt in summary month of 2023-03
    $(document).on('input','.tamount',function(){
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

    //for material modal
    $(document).on('click','.mat',function(){
        // Find the closest parent row of the clicked "drums" element
        var pmat = $(this).val();
      
        var mon= $('.mon').val();
        var selectedPmat = pmat;
       
        $.ajax({
            url:'summary_pmat_modal.php',
            type: 'post',
            data: {mon:mon,pmat:pmat},  
            // dataType: 'json',
            success:function(data){
              $('#bbb').html(data);  
              $('#pmat').modal('show');
            }
          });

        //when we click completed button  
    $(document).on('click','.completed',function(){

        var mon= $('.mon').val();
        var id = $('#temp').val();           
        
        $.ajax({
            url:'summary_pmatcomp_modal.php',
            type: 'post',
            data: {mon:mon,pmat:selectedPmat,id:id},  
            // dataType: 'json',
            success:function(data){
            $('#bbb').html(data);  
            //$('#pmat').modal('show');
            }
        });
    });

        //when we click on add button    
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
   
    // var btn=" <button type="button" class="btn rounded-pill common-btn save" name="updateButton" id="purchaseform">Update</button>";
    // var elementToReplace = document.getElementById("contentToReplace");
    //         elementToReplace.innerHTML = newHTML;
     
    });

    // Function to reset the button to "Save"
    function resetSaveButton() {
        var saveButton = $('.modal-footer .update');
        saveButton.text("Save");
        saveButton.removeClass("update").addClass("save");
        saveButton.attr("name", "purchaseform");
    }

    // Listen for the modal hidden event
    $('#pmat').on('hidden.bs.modal', function() {
        resetSaveButton(); // Call the function to reset the button
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