<?php
require_once "src/Controllers/ConnectController.php";

$material = array();
$stmt = $PDOconn->prepare("SELECT Material.*, Sending_Materal.Sup_ID 
                            FROM Material
                            LEFT JOIN Sending_Materal ON Material.M_SKU = Sending_Materal.M_SKU
                            ORDER BY Material.M_SKU ASC");

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $material[] = $row;
    }
}

$supplier = array();
$stmt = $PDOconn->prepare("SELECT * FROM Supplier");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $supplier[] = $row;
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
    <nav class="navbar navbar-expand-lg bg-light glassmorphism-light shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" ref="#">Department</a>
                    <a class="nav-link" href="department_manager.php">Department-Management</a>
                    <a class="nav-link" href="employee.php">Employee</a>
                    <a class="nav-link" href="quotation.php">Quotation</a>
                    <a class="nav-link" href="customer.php">Customer</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <h1>Material Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="col-auto" scope="col">รหัสวัสดุ</th>
                    <th class="col-auto" scope="col">ชื่อวัสดุ</th>
                    <th class="col-auto" scope="col">จำนวนสินค้าใน stock</th>
                    <th class="col-auto" scope="col">จำนวนคงเหลือ</th>
                    <th class="col-auto" scope="col">ราคาวัสดุ</th>
                    <th class="col-auto" scope="col">รหัสซัพพลายเออร์</th>
                    <th class="col-auto" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control ma-sku-input" maxlength="30" required />
                    </td>
                    <td>
                        <input class="form-control ma-name-input" maxlength="20" required/>
                    </td>
                    <td>
                        <input type="number" class="form-control ma-stock-input" />
                    </td>
                    <td>
                    </td>
                    <td>
                        <input type="number" class="form-control ma-price-input" />
                    </td>
                    <td>
                        <select class="form-select sup-id-select">
                            <option value=""></option>
                            <?php foreach ($supplier as $sup) : ?>
                                <option value="<?= $sup->Sup_ID; ?>"><?= $sup->Sup_ID ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php foreach ($material as $key => $ma) { ?>
                    <tr>
                        <td>
                            <span><?= $ma->M_SKU ?></span>
                            <input class="form-control ma-sku-input" maxlength="30" value="<?= $ma->M_SKU ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $ma->M_name ?></span>
                            <input class="form-control ma-name-input" maxlength="20" value="<?= $ma->M_name ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $ma->M_Stock ?></span>
                            <input type="number" class="form-control ma-stock-input" value="<?= $ma->M_Stock ?>" style="display: none;"  />
                        </td>
                        <td>
                            <span><?= $ma->M_numStock ?></span>
                        </td>
                        <td>
                            <span><?= $ma->M_price ?></span>
                            <input type="number" class="form-control ma-price-input" value="<?= $ma->M_price ?>" style="display: none;"  />
                        </td>
                        <td>
                            <span><?= $ma->Sup_ID ?> </span>
                            <select class="form-select sup-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option value="<?= $sup->Sup_ID; ?>" <?= ($sup->Sup_ID == $ma->Sup_ID) ? 'selected' : '' ?>><?= $sup->Sup_ID ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $ma->M_SKU ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $ma->M_SKU ?>" style="display: none;">Save</button>
                            <button class="btn btn-sm btn-warning cancel-btn" style="display: none;">Cancel</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    function validateFormControls(tr) {
        const formControls = tr.querySelectorAll('.form-control');

        formControls.forEach(function(control) {
            // Validate each form control
            if (control.required && control.value.trim() === '') {
                // If the control is empty, add is-invalid class
                control.classList.add('is-invalid');
            } else {
                // If the control is not empty, remove is-invalid class and add is-valid class
                control.classList.remove('is-invalid');
                control.classList.add('is-valid');
            }
        });
        // Check if any of the form controls have invalid values
        const invalidControls = tr.querySelectorAll('.is-invalid');
        if (invalidControls.length > 0) {
            // If there are invalid controls, display an error message
            console.log("Validation failed!");
            Swal.fire({
                icon: 'warning',
                text: 'Please fill in required field.'
            });
            return false; // Validation failed
        }

        return true; // Validation passed
    }

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
            const maSkuInput = tr.querySelector('.ma-sku-input').value;
            const maNameInput = tr.querySelector('.ma-name-input').value;
            const maStockInput = tr.querySelector('.ma-stock-input').value;
            const maPriceInput = tr.querySelector('.ma-price-input').value;
            const subIdSelect = tr.querySelector('.sup-id-select').value;
            fetch('api/material/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        maSkuInput,
                        maNameInput,
                        maStockInput,
                        maPriceInput,
                        subIdSelect
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
                const maSkuInput = tr.querySelector('.ma-sku-input').value;
                const maNameInput = tr.querySelector('.ma-name-input').value;
                const maStockInput = tr.querySelector('.ma-stock-input').value;
                const maPriceInput = tr.querySelector('.ma-price-input').value;
                const subIdSelect = tr.querySelector('.sup-id-select').value;
                fetch('api/material/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            maSkuInput,
                            maNameInput,
                            maStockInput,
                            maPriceInput,
                            subIdSelect
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
                    fetch('api/material/delete.php', {
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