<?php
include('../includes/dbcon.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$sql = "SELECT * from emp_rate_master where iId=$id";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

?>

<input type="hidden" name="id" value="<?php echo $row['iId'] ?>">

<div class="row mb-3">
    
    <div class="col-md-12">
        <label for="rate">Rate</label>
        <input type="number" name="rate" id="rate" class="form-control"
            value="<?php echo $row['rate'] ?>" required>
    </div>
</div>
