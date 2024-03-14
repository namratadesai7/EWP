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
    <title>Document</title>
    <style>
        .other,.material{
            display:none;
        }
       
       .abc{
        display:flex;
       
       }
        .fl{
            margin-top:2rem;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        .form-label{
            padding: 0px 5px !important;
        }
        #drumTable th{
            white-space: nowrap !important;
            /* font-size:0.8rem; */
            padding: 8px 6px;
            padding-left:0;
            padding-right:0;
        }
        #drumTable td{
            white-space:nowrap;
            /* font-size:0.8rem; */
            padding: 6px;
            padding-left:0;
            padding-right:0;

        }
        .tdCss{
            padding: 3px 6px !important;
        }
        #drumTable th,
        #drumTable td {
        text-align: center;
    }
    </style>
</head>
<body>

    <div class="container-fluid fl ">

            <div class="row mb-3">
                <div class="col">
                    <h4 class="pt-2 mb-0">Add Drum details</h4>
                </div>
                <div class="col-auto">
                    <a href="session_destroy.php"  class="btn  btn-danger" name="reset">Reset</a>
                </div>
                <div class="col-auto">
                    <form action="drumshift_getexcel.php" method="POST" >
                        <div class="abc">
                        <input type="month" id="month" class="form-control"  name="month">
						<button type="submit" class="btn btn-danger mx-1 getexcel" name="getexcel" >Export</button>
                        </div>
                       
					</form>
                </div>
            </div>
        <form action="drumshift_db.php" method="post" >
           
       
            <div class="divCss">
                <div class="row px-2">
                <?php
                if (isset($_SESSION['ch'])) {
                  
                    
                    $sql1="WITH top1 as(select max (id) as mid from Dshift  where challanno='".$_SESSION['ch']."')
                    select * from Dshift where id in(select mid from top1)
                    ";
                    $run1=sqlsrv_query($conn,$sql1);
                    $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

                    $cno=$row1['Challanno'];
                    $date=$row1['Date']->format('Y-m-d');
                    $nameoc=$row1['Name_of_contractor'];
                    $name=$row1['Name'];
                  
                    $fplant=$row1['From_Plant'];
                    $tplant=$row1['To_Plant'];
                    $dseries=$row1['Drum_series'];
                    $dnum=$row1['Drum_No'];
                    $type=$row1['Type'];
                    $stage=$row1['Stage'];
                    $material=$row1['Material'];
                    $other=$row1['Others'];
                    $ncore=$row1['No_of_core'];
                    $corepair=$row1['corepair'];
                    $sqmm=$row1['Sqmm'];
                    $ctype=$row1['ConductorType'];
                    $unit=$row1['Unit'];
                    $rem=$row1['Remark'];
                }else{
                    $sql="SELECT MAX(Challanno) AS ch FROM Dshift";
                    $run=sqlsrv_query($conn,$sql);
                    $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

                    $cno = (isset($_SESSION['reset']) || $row['ch'] == NULL) ? $row['ch']+1 : $row['ch'];
                    $date=date('Y-m-d');
                    $nameoc='RAMSAWARE';
                    $name='';
                    $fplant='';
                    $tplant='';
                    $dseries='';
                    $dnum='';
                    $stage='';
                    $type= '';
                    $material='';
                    $other='';
                    $ncore='';
                    $corepair='';
                    $sqmm='';
                    $ctype='';
                    $unit='';
                    $rem='';

                }
                
                // echo $nameoc;
                    ?>
                    <label class="form-label col-lg-3 col-md-6" for="cno">Challan No.
                        <input class="form-control " type="number" id="cno" name="cno"  value="<?php echo $cno ?>" required readonly>
                        
                    </label>
                  
                    <label class="form-label col-lg-3 col-md-6" for="date">Date
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $date ?>" required>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="nameoc">Name of Sub Contractor
                        <select  class="form-select" name="nameoc" id="nameoc"   >
                            <!-- <option value=""></option> -->
                            <?php
                            $sql="SELECT name FROM drum_contractor where isDelete=0 ";
                            $run=sqlsrv_query($conn,$sql);
                           while( $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
?>
                            <option <?php if( $nameoc==$row['name']) { ?> selected <?php } ?>  ><?php echo $row['name']  ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="name">Name
                        <select  class="form-select" name="name" id="name"  required>
                            <option disabled selected value=""></option>
                            <?php
                             $sql1="SELECT name FROM drum_name where isDelete=0";
                             $run1=sqlsrv_query($conn,$sql1);
                            while( $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
?>
                            <option <?php if( $name==$row1['name']){  ?>selected <?php } ?> ><?php echo $row1['name']   ?></option>
                            <?php } ?> 
                        </select>
                    </label>
                    <label  class="form-label col-lg-3 col-md-6" for="fplant">From-Plant
                        <select  class="form-select" name="fplant" id="fplant"  required>
                            <option disabled selected value="" ></option>
                            <?php
                             $sql2="SELECT name FROM drum_plant where isDelete=0";
                             $run2=sqlsrv_query($conn,$sql2);
                            while( $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
?>  
                            <option <?php if($fplant==$row2['name'] )   { ?> selected <?php } ?> ><?php echo $row2['name']   ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label  class="form-label col-lg-3 col-md-6" for="tplant">To-Plant
                        <select  class="form-select" name="tplant" id="tplant" required  >
                            <option disabled selected value=""></option>
                            <?php
                            $sql2="SELECT name FROM drum_plant where isDelete=0";
                            $run2=sqlsrv_query($conn,$sql2);
                            while( $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
                            ?>  
                            <option <?php if($tplant==$row2['name'] )   { ?> selected <?php } ?> ><?php echo $row2['name']   ?></option>
                            <?php } ?>
                        </select>
                    </label>
                     
                    <label  class="form-label col-lg-3 col-md-6" for="type">Type
                        <select  class="form-select" name="type" id="type" required  onchange="toggleRequired()">>
                            <option disabled value=""></option>
                            <option selected value="drums">Drums</option>
                            <option  value="Raw Material">Raw Material</option>
                            <option  value="Scrap/General">Scrap/General</option>
                        </select>
                    </label>
                    <label  class="form-label col-lg-3 col-md-6 stage" for="stage">Stage
                        <select  class="form-select" name="stage" id="stage" required>
                            <option disabled selected value=""></option>
                            <?php
                            $sql3="SELECT name FROM drum_stage where isDelete=0";
                            $run3=sqlsrv_query($conn,$sql3);
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                            ?>  
                            <option <?php if($stage==$row3['name']){ ?> selected  <?php } ?> ><?php echo $row3['name'] ?></option>                        
                            <?php } ?>
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6 material" for="material">Material
                       
                        <select  class="form-select" name="material" id="material"  >
                 
                        <?php
                        $sql3="SELECT name FROM drum_material where isDelete=0";
                        $run3=sqlsrv_query($conn,$sql3);
        
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                            ?>  
                            <option   ><?php echo $row3['name'] ?></option>                        
                            <?php } ?>
                        </select>
                    </label>

                    <label  class="form-label col-lg-3 col-md-6 other" for="other" >Other
                        <select  class="form-select" id="other"  name="other" >
                         
                            <?php
                            $sql3="SELECT name FROM drum_other where isDelete=0";
                            $run3=sqlsrv_query($conn,$sql3);
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                            ?>  
                            <option  ><?php echo $row3['name'] ?></option>                        
                            <?php } ?>
                             <!-- <option value="ALUMINIUM SCRAP">ALUMINIUM SCRAP</option>
                             <option value="COPPER SCRAP">COPPER SCRAP</option>
                             <option value="INSULATED WIRE SCRAP">INSULATED WIRE SCRAP</option>
                             <option value="PVC SCRAP">PVC SCRAP</option>
                             <option value="MACHINARY PART">MACHINARY PART</option>
                             <option value="MACHINE">MACHINE</option>
                             <option value="M/S MATERIA">M/S MATERIA</option>   
                             <option value="Tape">Tape</option>   
                             <option value="BARE COPPER">BARE COPPER</option>   
                             <option value="TIN COPPER REEL">TIN COPPER REEL</option> -->
                        </select>
                    </label>
                
                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="dseries">Drum Series
                        <select  class="form-select" name="dseries" id="dseries"  >
                            <option disabled selected value=""></option>
                            <?php
                            $sql3="SELECT name FROM drum_series where isDelete=0";
                            $run3=sqlsrv_query($conn,$sql3);
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                            ?>  
                            <option <?php if($dseries==$row3['name'])   { ?> selected <?php } ?> ><?php echo $row3['name'] ?></option>                        
                         <?php } ?>                   
                        </select>
                    </label>

                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="dnum">Drum No.
                        <input class="form-control" type="number" id="dnum" name="dnum" value="<?php echo $dnum ?>">
                    </label>

                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="ncore">No of. Core
                        <input step="0.01" class="form-control" type="number" id="ncore" name="ncore" value="<?php echo $ncore ?>">
                    </label>
                    
                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="corepair">Core/Pair
                        <select  class="form-select" name="corepair" id="corepair">
                            <option value=""></option>
                            <option <?php if($corepair=="core") { ?> selected <?php } ?> value="core">Core</option>
                            <option <?php if($corepair=="pair") { ?> selected <?php } ?> value="pair">Pair</option>
                            <option <?php if($corepair=="filler") { ?> selected <?php } ?> value="filler">Filler</option>
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="sqmm">Sqmm
                        <input class="form-control" type="number" step="0.01" id="sqmm" name="sqmm" value="<?php echo $sqmm ?>">
                    </label>
                    
                    <label  class="form-label col-lg-2 col-md-6 hideLabel" for="ctype">Conductor-Type
                        <select  class="form-select" name="ctype" id="ctype">
                            <option value=""></option>
                            <?php
                                $sql5="SELECT name FROM drum_conductor where isDelete=0";
                                $run5=sqlsrv_query($conn,$sql5);
                                while( $row5=sqlsrv_fetch_array($run5,SQLSRV_FETCH_ASSOC)){
                                ?>  
                                <option <?php if($ctype==$row5['name']) { ?> selected <?php } ?> ><?php echo $row5['name'] ?></option>                        
                            <?php } ?>
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-2 col-md-6" for="qty">Qnty
                        <input class="form-control" type="number" id="qty" name="qty" required> 
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="unit">Unit
                        <select  class="form-select" name="unit" id="unit" required>
                            <option value=""></option>
                            <option  <?php if($unit=="nos") { ?> selected <?php } ?> value="nos">Nos</option>
                            <option  <?php if($unit=="mtr") { ?> selected <?php } ?> value="mtr">Mtr</option>
                            <option  <?php if($unit=="kg") { ?> selected <?php } ?>  value="kg">Kg</option>
                        </select>
                    </label>
                    <label class="form-label col-lg-7 col-md-6" for="rem">Remark
                        <input class="form-control" type="text" id="rem" name="rem" >
                    </label>
                    <div class="row">
                       <div class="col"></div>             
                        <div class="col-auto">
                            <a type="" class="btn  rounded-pill btn-secondary mt-3 float-end" href="drumshift.php">Back</a>
                           <button type="submit" class="btn  rounded-pill common-btn me-2 mt-3 float-end"  name="save" >Save</button>
                        </div>
                        
                            <!-- <a href="session_destroy.php"  class="btn rounded-pill btn-danger mt-2" name="reset">Reset</a> -->
                        </div>     
                    </div>
                </div> <br>       
            </form>
     
        <div class="divCss " id="putTable">
        <div id="spinLoader"></div>
            <table class="table table-bordered text-center table-striped table-hover mb-0" id="drumTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Chal. No.</th>
                        <th>Date</th>
                        <th>Contractor Name</th>
                        <th>Name</th>
                        <th>From Plant</th>
                        <th>To Plant </th>
                        <th>Type</th>
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
                            $sql="SELECT * FROM Dshift WHERE format(Date,'yyyy')='$year' order by Date desc, id DESC"; // format(Date,'MM')='$mon' and 
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
                                <td><?php echo $row['Type'] ?></td>
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
        </div>
        
        
    </div>
</body>
</html>
<script>
    $('#dshift').addClass('active');

    $(document).ready(function() {
        var materialSelect = $('#material');
            var otherselect= $('#other');
            
            var dseriesselect=$('#dseries');
            var dnumselect=$('#dnum');
            var ncoreselect=$('#ncore');
            var corepairselect=$('#corepair');
            var sqmmselect=$('#sqmm');
            var ctypeelect=$('#ctype');
         
            dseriesselect.prop('required', true);
            dnumselect.prop('required', true);
            ncoreselect.prop('required', true);
            corepairselect.prop('required', true);
            sqmmselect.prop('required', true);
            ctypeelect.prop('required', true);
            materialSelect.prop('required', false);
            otherselect.prop('required', false);
        $('#type').change(function() {
          
            var selectedType = $(this).val();

          if (selectedType === 'Raw Material') {
                dseriesselect.prop('required', false);
                dnumselect.prop('required', false);
                ncoreselect.prop('required', false);
                corepairselect.prop('required', false);
                sqmmselect.prop('required', false);
                ctypeelect.prop('required', false);

                materialSelect.prop('required', true);
                otherselect.prop('required', false);
            } else if(selectedType === 'Scrap/General') {
                dseriesselect.prop('required', false);
                dnumselect.prop('required', false);
                ncoreselect.prop('required', false);
                corepairselect.prop('required', false);
                sqmmselect.prop('required', false);
                ctypeelect.prop('required', false);

                otherselect.prop('required', true);
                materialSelect.prop('required', false);
            }
        });
    });

    $(document).on('click','.getexcel',function(){
        var mon=$('#month').val();
        console.log(mon);
        })

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
                    'pageLength','copy', 'excel',
                    {
                        text:'ViewAll', className:'viewall',
                        action:function(){
                            $('#spinLoader').html('<span class="spinner-border spinner-border-lg mx-2"></span><p>Loading..</p>');
                            $('#putTable').css({"opacity":"0.5"});

                            $.ajax({
                                url:'drumshift_view.php',
                                type:'post',
                                data:{ },
                                success:function(data){
                                    $('#putTable').html(data);
                                    $('#spinLoader').html('');
                                    $('#putTable').css({"opacity":"1"});
                                }
                            });
                        }
                    },
                ]
            });
 	});

    // for making stage/material/other required.
     function toggleRequired() {
        console.log("sds");
        var typeSelect = document.getElementById("type");
        var stageSelect = document.getElementById("stage");
        var materialSelect = document.getElementById("material");
    
        var dseriesSelect = document.getElementById("dseries");

        if (typeSelect.value === "drums") {
            stageSelect.required = true;
            materialSelect.required = false;
 
            dseriesSelect.required= true;
        } else if (typeSelect.value === "Raw Material") {
            console.log("dss");
            stageSelect.required = false;
            materialSelect.required = true;
 
            dseriesSelect.required= false;
        } else {
            stageSelect.required = false;
            materialSelect.required = false;
        
            dseriesSelect.required= false;
        }
    }

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

        document.getElementById('date').setAttribute("max", today);
        document.getElementById('date').setAttribute("min", last);

        $(document).on('change','#stage',function(){
            var stage = $(this).val();
            var stg = stage.split(' ');
            if(stg[1] == 'DRUMS' || stg[2] == 'DRUMS'){
                $('.hideLabel').show();
            }else{
                $('.hideLabel').hide();
            }

            if(stage == 'DUMMY CORE DRUMS'){
                $('#corepair').val('filler');
                $('#ctype').val('PVC FILLER');
            }
        });

        $(document).on('change','#type',function(){
            var type = $(this).val();
            if(type=='drums'){
                $('.stage').show();
                $('.material').hide();
                $('.other').hide();
                $('.hideLabel').show();


            }
            if(type=='Raw Material'){
                $('.stage').hide();
                $('.material').show();
                $('.other').hide();
                $('.hideLabel').hide();

            }
            if(type=='Scrap/General'){
                $('.stage').hide();
                $('.material').hide();
                $('.other').show();
                $('.hideLabel').hide();

            }



        })

        //for plant selection
        $(document).on('change','#fplant',function(){
            var fplant = $(this).val();
            if(fplant == '1701'){
                $('#tplant').val(2205);
            }else if (fplant == "2205") {
                $('#tplant').val(1701);
            }else{
                $('#tplant').val('');
            }
        });

        $(document).on('change','#type,#fplant,#tplant',function(){
            var type = $('#type').val();
            var fplant=$('#fplant').val();
            var tplant=$('#tplant').val();
            console.log(fplant);
            if(type=='Raw Material' && fplant==tplant){
        
                $('#material').val('PVC COMPOUND ( IN PLANT )');
                var optionToDisable = $('#material option').filter(function() {
                     return $(this).val() === 'PVC COMPOUND';
                });
                optionToDisable.prop('disabled', true);

        
            }
            else{
                $('#material').val('');

            }
        });


  
 
</script>
<?php

include('../includes/footer.php');
?>