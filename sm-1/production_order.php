<?php
require_once "src/Controllers/ConnectController.php";

$product_order = array();
$stmt = $PDOconn->prepare("SELECT Production_Order.*, Material_PO.M_SKU
                            FROM Production_Order
                            LEFT JOIN Material_PO ON Production_Order.PO_ID = Material_PO.PO_ID
                            ORDER BY Production_Order.PO_ID ASC");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $product_order[] = $row;
    }
}

$material = array();
$stmt = $PDOconn->prepare("SELECT * FROM Material");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $material[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="public/css/loading.css" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="public/css/main.css" type="text/css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <a class="nav-link" href="department.php">Department</a>
                    <!-- <a class="nav-link" href="department_manager.php">Department-Management</a> -->
                    <a class="nav-link" href="employee.php">Employee</a>
                    <a class="nav-link" href="quotation.php">Quotation</a>
                    <a class="nav-link" href="customer.php">Customer</a>
                    <a class="nav-link" href="project.php">Project</a>
                    <a class="nav-link" href="supplier.php">Supplier</a>
                    <a class="nav-link" href="material.php">Material</a>
                    <a class="nav-link active" aria-current="page" href="#">Production-Order</a>
                    <a class="nav-link " href="area-measurement-sheet.php">Area-measurement-sheet</a>
                    <a class="nav-link" href="bill.php">Bill</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <input type="text" id="myInput" class="form-control mb-5" onkeyup="filter()" placeholder="ค้นหา">
        <h1>product Order Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr class="table-primary">
                    <th class="col-auto" scope="col">เลขที่ใบสั่งผลิต</th>
                    <th class="col-auto" scope="col">เดือนในการผลิต</th>
                    <th class="col-auto" scope="col">รายละเอียดใบสั่งผลิต</th>
                    <th class="col-auto" scope="col">รหัสวัสดุ</th>
                    <th class="col-auto" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control pro-id-input" maxlength="6" required />
                    </td>
                    <td>
                        <input class="form-control pro-month-input" maxlength="4" />
                    </td>
                    <td>
                        <input class="form-control pro-detail-input" maxlength="1000" />
                    </td>
                    <td>
                        <select class="form-select ma-sku-select">
                            <option value=""></option>
                            <?php foreach ($material as $ma) { ?>
                                <option value="<?= $ma->M_SKU ?>">
                                    <?= $ma->M_SKU ?>
                                </option>
                            <?php } ?>
                        </select>

                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php foreach ($product_order as $key => $pro) { ?>
                    <tr>
                        <td>
                            <span><?= $pro->PO_ID ?></span>
                            <input class="form-control pro-id-input" maxlength="6" value="<?= $pro->PO_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $pro->PO_month ?></span>
                            <input class="form-control pro-month-input" maxlength="4" value="<?= $pro->PO_month ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $pro->PO_detail ?></span>
                            <input class="form-control pro-detail-input" maxlength="1000" value="<?= $pro->PO_detail ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $pro->M_SKU ?></span>
                            <select class="form-select ma-sku-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($material as $ma) { ?>
                                    <option value="<?= $ma->M_SKU ?>" <?= ($ma->M_SKU == $pro->M_SKU) ? 'selected' : '' ?>>
                                        <?= $ma->M_SKU ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $pro->PO_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $pro->PO_ID ?>" style="display: none;">Save</button>
                            <button class="btn btn-sm btn-warning cancel-btn" style="display: none;">Cancel</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

<script src="public/js/main.js"></script>
<script>
    // Get insert button
    const insertButton = document.getElementById('insert-btn');
    // Attach event listener to insert button
    insertButton.addEventListener('click', function() {
        const insertForm = document.querySelector('.insert-form');
        const tr = insertForm.closest('tr');
        tr.style.display = 'table-row'; // Display the tr
        // Get cancel button
        const cancelButton = tr.querySelector('.cancel-btn');
        // Attach event listener to cancel button
        cancelButton.addEventListener('click', function() {
            insertForm.style.display = 'none'; // Hide the tr
        });
        // Get save button
        const saveButton = tr.querySelector('.save-btn');
        // Attach event listener to save button
        saveButton.addEventListener('click', function() {
            // Validate the form controls
            if (!validateFormControls(tr)) {
                // If validation fails, abort saving
                return;
            }
            // If validation passes, proceed with api
            console.log("Validation passed ...");
            const proIdInput = tr.querySelector('.pro-id-input').value;
            const proMonthInput = tr.querySelector('.pro-month-input').value;
            const proDetailInput = tr.querySelector('.pro-detail-input').value;
            const maSkuSelect = tr.querySelector('.ma-sku-select').value;
            fetch('api/production_order/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proIdInput,
                        proMonthInput,
                        proDetailInput,
                        maSkuSelect
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(JSON.stringify({
                            title: 'ขออภัย !',
                            message: 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้งในภายหลัง',
                            icon: 'error',
                            status: response.status
                        }));
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "บันทึกสำเร็จ",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    const errorData = JSON.parse(error.message);
                    Swal.fire({
                        title: errorData.title,
                        text: errorData.message,
                        icon: errorData.icon
                    });
                });
        });
    });

    // Get all edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    // Loop through each edit button to attach event listener
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const tr = this.closest('tr');
            const editBtn = tr.querySelector('.edit-btn');
            const saveBtn = tr.querySelector('.save-btn');
            const delBtn = tr.querySelector('.del-btn');
            const cancelBtn = tr.querySelector('.cancel-btn');
            editBtn.style.display = 'none';
            delBtn.style.display = 'none';
            saveBtn.style.display = 'inline';
            cancelBtn.style.display = 'inline';
            const spans = tr.querySelectorAll('span');
            spans.forEach(function(span) {
                span.style.display = 'none';
            });
            const inputs = tr.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.style.display = 'inline';
            });
            const selects = tr.querySelectorAll('select');
            selects.forEach(function(select) {
                select.style.display = 'inline';
            });
            saveBtn.addEventListener('click', function() {
                // Validate the form controls
                if (!validateFormControls(tr)) {
                    // If validation fails, abort saving
                    return;
                }
                // If validation passes, proceed with api
                console.log("Validation passed ...");
                const proIdInput = tr.querySelector('.pro-id-input').value;
                const proMonthInput = tr.querySelector('.pro-month-input').value;
                const proDetailInput = tr.querySelector('.pro-detail-input').value;
                const maSkuSelect = tr.querySelector('.ma-sku-select').value;
                fetch('api/production_order/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            proIdInput,
                            proMonthInput,
                            proDetailInput,
                            maSkuSelect
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(JSON.stringify({
                                title: 'ขออภัย !',
                                message: 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้งในภายหลัง',
                                icon: 'error',
                                status: response.status
                            }));
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        Swal.fire({
                            icon: "success",
                            title: "บันทึกสำเร็จ",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            willClose: () => {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        const errorData = JSON.parse(error.message);
                        Swal.fire({
                            title: errorData.title,
                            text: errorData.message,
                            icon: errorData.icon
                        });
                    });
            });
            // Attach event listener to cancel button
            cancelBtn.addEventListener('click', function() {
                spans.forEach(function(span) {
                    span.style.display = 'inline';
                });
                inputs.forEach(function(input) {
                    input.style.display = 'none';
                });
                selects.forEach(function(select) {
                    select.style.display = 'none';
                });
                editBtn.style.display = 'inline';
                delBtn.style.display = 'inline';
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            });
        });
    });

    // Get all delete buttons
    const delButtons = document.querySelectorAll('.del-btn');
    // Loop through each edit button to attach event listener
    delButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Display confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete !'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('api/production_order/delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                ID: this.value
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(JSON.stringify({
                                    title: 'ขออภัย !',
                                    message: 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้งในภายหลัง',
                                    icon: 'error',
                                    status: response.status
                                }));
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                            Swal.fire({
                                icon: "success",
                                title: "บันทึกสำเร็จ",
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                willClose: () => {
                                    window.location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            const errorData = JSON.parse(error.message);
                            Swal.fire({
                                title: errorData.title,
                                text: errorData.message,
                                icon: errorData.icon
                            });
                        });
                }
            });
        });
    });
</script>

</html>