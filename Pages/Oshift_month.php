<?php
include('../includes/dbcon.php'); 
$mon=$_POST['month'];
$year=$_POST['year'];

?>
   <table class="table table-bordered table-sm text-center table-striped table-hover mb-0" id="challantable">
                <thead>
                    <tr class="bg-secondary text-light">
                    <th>Sr</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Team Name</th>
                        <th>M.p</th>
                        <th>Work</th>
                        <th>Total WT/Qty</th>
                        <th>Rate</th>
                        <th> Amt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                        <?php
                            $sr=1;
                          
                            $sql="SELECT id, Type,Date,Month, Teamname,workdet,mp, Totalwt, Rate,Amount
                            FROM Oshift 
                           where Month='$mon' and format(Date,'yyyy')='$year' and Isdelete='0'";
                            $run=sqlsrv_query($conn,$sql);
                            $printedSrNos = array();
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                                                      
                        ?>
                            <tr>
                            
                            <td ><?php echo $sr ?></td>
                            <td  ><?php if($row['Type'] =='Manpower'){ echo "Manpower";
                             }elseif($row['Type'] =='Drum  Wrapping'){ echo "Drum  Wrapping"; }    ?></td>
                            <td ><?php echo $row['Date']->format("Y-m-d") ?></td>
                         
                            <td ><?php echo $row['Month']  ?></td>
                            <td ><?php echo $row['Teamname']  ?></td>
                            <td ><?php echo $row['mp']  ?></td>
                            <td><?php echo $row['workdet'] ?></td>
                      
                            <td ><?php echo $row['Totalwt']  ?></td>
                            <td ><?php echo $row['Rate']  ?></td>    
                            <td ><?php echo $row['Amount']  ?></td>   
                                                
                            <td  class="tdCss" ><a href="Oshift_edit.php?edit=<?php echo $row['id']?>"  class="btn rounded-pill btn-warning btn-sm"  >Edit</a>
                            <a href="Oshift_db.php?delete=<?php echo $row['id'] ?>" class="btn rounded-pill btn-danger btn-sm delete" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a></td>
                        </tr>
                        <?php
                      $sr++; 
                         }
                        ?>                                       
                </tbody>
            </table>

