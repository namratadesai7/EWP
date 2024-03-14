<?php
include('../includes/dbcon.php'); 
$mon=$_POST['month'];
$year=$_POST['year'];

?>
   <table class="table table-bordered table-sm text-center table-striped table-hover mb-0" id="challantable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr</th>
                        <th>Challan No.</th>
                        <th>Date</th>
                        <th>Name of contractor</th>
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                        <?php
                            $sr=1;
                          
                            $sql="SELECT DISTINCT(Challanno),Date,Name_of_contractor FROM Dshift where format(Date,'MM')='$mon'
                             and format(Date,'yyyy')='$year' and (Type='drums' or Type is null)  and Challanno not in (select distinct(Challanno) from Challan)and Type='drums'  order by Date desc";
                            $run=sqlsrv_query($conn,$sql);
                            $printedSrNos = array();
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                                                      
                        ?>
                            <tr>
                                <td ><?php echo $sr?></td>
                                <td><?php echo $row['Challanno'] ?></td>
                                <td ><?php echo $row['Date']->format('d-m-Y')  ?></td>
                                <td class="tname" ><?php echo $row['Name_of_contractor']  ?></td>                
                                <td  class="tdCss" ><a class="btn rounded-pill btn-warning btn-sm view" id="<?php echo $row['Challanno'] ?>"  >View</a>
                                <a href="challanpdf.php?pdf=<?php echo $row['Challanno']?>" style="font-size: 12px;" class="btn btn-danger btn-sm rounded-pill" target="_blank">Pdf</a>
                                      </td>
                            </tr>
                        <?php
                      $sr++; 
                         }
                        ?>                                       
                </tbody>
            </table>

