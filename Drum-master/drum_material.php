<?php
include("../includes/dbcon.php");
include("../includes/header.php");


// Read material Data from Database
$sql = "SELECT * from drum_material where isDelete = '0'";
$result = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Material Data</h4>
            </div>
            <div class="col-auto">
                <button class="btn rounded-pill common-btn add-new" data-bs-toggle="modal" data-bs-target="#addModal">+
                    Add New</button>
            </div>
        </div>
        <?php
        if (isset($_SESSION['insert'])) {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                <?= $_SESSION['insert']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="insert"></button>
            </div>
            <?php
            unset($_SESSION['insert']);
        }
        if (isset($_SESSION['update'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                <?= $_SESSION['update']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="update"></button>
            </div>
            <?php
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['delete'])) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <?= $_SESSION['delete']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="delete"></button>
            </div>
            <?php
            unset($_SESSION['delete']);
        }
        ?>
        <div class="divCss">
            <table class="table table-bordered text-center mb-0">
                <thead>
                    <tr class="bg-light">
                        <th>Sr</th>
                        <th>Material</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                        <tr>
                            <th>
                                <?php echo $row['id'] ?>
                            </th>
                            <td>
                                <?php echo $row['name'] ?>
                            </td>
                            <td>
                                <?php echo $row['rate'] ?>
                            </td>
                            <td>
                                <button data-name="<?php echo $row['name'] ?>"  data-rate="<?php echo $row['rate'] ?>" 
                                id=<?php echo $row['id'] ?>
                                    class="edit btn btn-primary btn-sm" >Edit</button>
                                <a href="drum_material_db.php?deleteid=<?php echo $row['id'] ?>"
                                    onclick="return confirm('Are you sure?')" name="delete"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

    <!------------------ Add new modal ------------------->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Material Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="drum_material_db.php" method="post">
                    <div class="mb-3">
                        <label for="name">Material</label>
                        <input type="text" name="name" id="name" placeholder="Enter Unit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate">Rate</label>
                        <input type="number" name="rate" id="rate" placeholder="Enter Rate" class="form-control" required>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn common-btn btn-sm" form="addForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------Edit Modal---------------------------------------->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Stage Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="drum_material_db.php" method="post">
                    <input type="hidden" id="editId" name="editId">
                    <div class="mb-3">
                        <label for="name">Material</label>
                        <input type="text" name="editName" id="editName" placeholder="Enter Unit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate">Rate</label>
                        <input type="number" id="editRate" name="editRate" class="form-control" required>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn common-btn btn-sm" form="editForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $('#dmat').addClass('active');
    $('#drumMenu').addClass('showMenu');
    $(document).on('click', '.edit', function () {
        var editid = $(this).attr('id');
        var name = $(this).data('name');
        var rate = $(this).data('rate');
        $('#editId').val(editid);
        $('#editName').val(name);
        $('#editRate').val(rate);
        $('#editModal').modal('show');
    });
</script>
<?php
include("../includes/footer.php");

?>