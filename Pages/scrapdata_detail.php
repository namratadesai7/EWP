<?php
include('../includes/dbcon.php');
 
if(isset($_POST['stype'])){
    $stype = $_POST['stype'];
    $Array= array();
    if($stype=='CP' || $stype=='IP' ){
        $sql1="SELECT * FROM [EWP].[dbo].[scrap_rate_master] WHERE type='$stype' AND is_update=0";
        $run1=sqlsrv_query($conn,$sql1);
        $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
        $name=array('bare_cu','tin_cu','alu','pvc','xlpe','gi','tape_r','pvc_d');
    for($i=0;$i<8;$i++){ 
        $Array[$i]= $row1[$name[$i]];
}
}else{
    $Array=[0,0,0,0,0,0,0,0];
}
echo json_encode($Array);
}
if(isset($_POST['stype1'])){
    $stype1 = $_POST['stype1'];
    if($stype1=='RO'){
    ?>
        <table class="table table-bordered text-center mb-0" id="scrapTable" >
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
                        $name=array('PVC','XLPE','GI',);
                        $name1=array('pvc','xlpe','gi');
                    // $rate=array('6','6','5','3','3','2','0','2');
                        $qty=array();
                        for($i=0;$i<3;$i++){                
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
        </table> 
    <?php
     }else{
        ?>

        <table  class="table table-bordered text-center mb-0" id="scrapTable" >
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
        </table>  
        <?php





  }


    ?>
    


<?php


}
?>
  