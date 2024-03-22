<?php
require_once "src/Controllers/ConnectController.php";

$bill = array();

$stmt = $PDOconn->prepare("SELECT Bill.*, Customer.*
                            FROM Bill
                            LEFT JOIN Customer ON Bill.Cus_ID = Customer.Cus_ID ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $bill[] = $row;
    }
}

$customer = array();
$stmt = $PDOconn->prepare("SELECT * FROM Customer");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $customer[] = $row;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                    <a class="nav-link" href="department.php">Department</a>
                    <a class="nav-link" href="department_manager.php">Department-Management</a>
                    <a class="nav-link" href="employee.php">Employee</a>
                    <a class="nav-link" href="quotation.php">Quotation</a>
                    <a class="nav-link active" aria-current="page" href="#">Customer</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <h1>Bill Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>เลขใบเสร็จ</th>
                    <th>รอบชำระ 50%</th>
                    <th>รอบชำระ 30%</th>
                    <th>รอบชำระ 20%</th>
                    <th>สถานะการชำระเงินรอบ 50%</th>
                    <th>สถานะการชำระเงินรอบ 30%</th>
                    <th>สถานะการชำระเงินรอบ 20%</th>
                    <!-- <th>หลักฐานการชำระเงินรอบ 50%</th>
                    <th>หลักฐานการชำระเงินรอบ 30%</th>
                    <th>หลักฐานการชำระเงินรอบ 20%</th> -->
                    <th>วันที่ชำระรอบ 50%</th>
                    <th>วันที่ชำระรอบ 30%</th>
                    <th>วันที่ชำระรอบ 20%</th>
                    <th>รหัสลูกค้า</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input type="text" class="form-control bi-id-input" maxlength="6" required />
                    </td>
                    <td>
                        <input type="number" class="form-control bi-pay50-input" />
                    </td>
                    <td>
                        <input type="number" class="form-control bi-pay30-input" />
                    </td>
                    <td>
                        <input type="number" class="form-control bi-pay20-input" />
                    </td>
                    <td>
                        <input type="text" class="form-control bi-status50-input" maxlength="10" />
                    </td>
                    <td>
                        <input type="text" class="form-control bi-status30-input" maxlength="10" />
                    </td>
                    <td>
                        <input type="text" class="form-control bi-status20-input" maxlength="10" />
                    </td>
                    <!-- <td>
                            <span><?= $bi->Slip_50 ?></span>
                            <input type="number" class="form-control bi-slip50-input" value="<?= $bi->Slip_50 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Slip_30 ?></span>
                            <input type="number" class="form-control bi-slip30-input" value="<?= $bi->Slip_30 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Slip_20 ?></span>
                            <input type="number" class="form-control bi-slip20-input" value="<?= $bi->Slip_20 ?>" style="display: none;" />
                        </td> -->
                    <td>
                        <input id="datepicker" class="form-control bi-datepay50-input" placeholder="เลือกวันที่ ..">
                    </td>
                    <td>
                        <input id="datepicker" class="form-control bi-datepay30-input" placeholder="เลือกวันที่ ..">
                    </td>
                    <td>
                        <input id="datepicker" class="form-control bi-datepay20-input" placeholder="เลือกวันที่ ..">
                    </td>
                    <td>
                        <select class="form-select cus-id-select">
                            <option value=""></option>
                            <?php foreach ($customer as $cus) { ?>
                                <option value="<?= $cus->Cus_ID; ?>"><?= $cus->Cus_ID ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($bill as $bi) {
                ?>
                    <tr>
                        <td>
                            <span><?= $bi->Bill_ID ?></span>
                            <input type="text" class="form-control bi-id-input" maxlength="6" value="<?= $bi->Bill_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $bi->Pay_50 ?></span>
                            <input type="number" class="form-control bi-pay50-input" value="<?= $bi->Pay_50 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Pay_30 ?></span>
                            <input type="number" class="form-control bi-pay30-input" value="<?= $bi->Pay_30 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Pay_20 ?></span>
                            <input type="number" class="form-control bi-pay20-input" value="<?= $bi->Pay_20 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Status_50 ?></span>
                            <input type="text" class="form-control bi-status50-input" maxlength="10" value="<?= $bi->Status_50 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Status_30 ?></span>
                            <input type="text" class="form-control bi-status30-input" maxlength="10" value="<?= $bi->Status_30 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Status_20 ?></span>
                            <input type="text" class="form-control bi-status20-input" maxlength="10" value="<?= $bi->Status_20 ?>" style="display: none;" />
                        </td>
                        <!-- <td>
                            <span><?= $bi->Slip_50 ?></span>
                            <input type="number" class="form-control bi-slip50-input" value="<?= $bi->Slip_50 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Slip_30 ?></span>
                            <input type="number" class="form-control bi-slip30-input" value="<?= $bi->Slip_30 ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $bi->Slip_20 ?></span>
                            <input type="number" class="form-control bi-slip20-input" value="<?= $bi->Slip_20 ?>" style="display: none;" />
                        </td> -->
                        <td>
                            <span><?= $bi->DatePay_50 ?></span>
                            <input id="datepicker" class="form-control bi-datepay50-input" value="<?= $bi->DatePay_50 ?>" placeholder="เลือกวันที่ .." style="display: none;">
                        </td>
                        <td>
                            <span><?= $bi->DatePay_30 ?></span>
                            <input id="datepicker" class="form-control bi-datepay30-input" value="<?= $bi->DatePay_30 ?>" placeholder="เลือกวันที่ .." style="display: none;">
                        </td>
                        <td>
                            <span><?= $bi->DatePay_20 ?></span>
                            <input id="datepicker" class="form-control bi-datepay20-input" value="<?= $bi->DatePay_20 ?>" placeholder="เลือกวันที่ .." style="display: none;">
                        </td>
                        <td>
                            <span>
                                <?php foreach ($customer as $cus) { ?>
                                    <?= ($bi->Cus_ID == $cus->Cus_ID) ? $cus->Cus_ID : '' ?>
                                <?php } ?>
                            </span>
                            <select class="form-select cus-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($customer as $cus) { ?>
                                    <option value="<?= $cus->Cus_ID; ?>" <?= ($cus->Cus_ID == $bi->Cus_ID) ? 'selected' : '' ?>><?= $cus->Cus_ID ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $bi->Bill_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $bi->Bill_ID ?>" style="display: none;">Save</button>
                            <button class="btn btn-sm btn-warning cancel-btn" style="display: none;">Cancel</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    // Initialize Flatpickr
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d", // Date format
    });
</script>
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
            const biIdInput = tr.querySelector('.bi-id-input').value;
            const biPay50Input = tr.querySelector('.bi-pay50-input').value;
            const biPay30Input = tr.querySelector('.bi-pay30-input').value;
            const biPay20Input = tr.querySelector('.bi-pay20-input').value;
            const biStatus50Input = tr.querySelector('.bi-status50-input').value;
            const biStatus30Input = tr.querySelector('.bi-status30-input').value;
            const biStatus20Input = tr.querySelector('.bi-status20-input').value;
            const biDatePay50Input = tr.querySelector('.bi-datepay50-input').value;
            const biDatePay30Input = tr.querySelector('.bi-datepay30-input').value;
            const biDatapay20Input = tr.querySelector('.bi-datepay20-input').value;
            const cusIdSelect = tr.querySelector('.cus-id-select').value;
            fetch('api/area-measurement-sheet/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        biIdInput,
                        biPay50Input,
                        biPay30Input,
                        biPay20Input,
                        biStatus50Input,
                        biStatus30Input,
                        biStatus20Input,
                        biDatePay50Input,
                        biDatePay30Input,
                        biDatapay20Input,
                        cusIdSelect
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
                const biIdInput = tr.querySelector('.bi-id-input').value;
                const biPay50Input = tr.querySelector('.bi-pay50-input').value;
                const biPay30Input = tr.querySelector('.bi-pay30-input').value;
                const biPay20Input = tr.querySelector('.bi-pay20-input').value;
                const biStatus50Input = tr.querySelector('.bi-status50-input').value;
                const biStatus30Input = tr.querySelector('.bi-status30-input').value;
                const biStatus20Input = tr.querySelector('.bi-status20-input').value;
                const biDatePay50Input = tr.querySelector('.bi-datepay50-input').value;
                const biDatePay30Input = tr.querySelector('.bi-datepay30-input').value;
                const biDatapay20Input = tr.querySelector('.bi-datepay20-input').value;
                const cusIdSelect = tr.querySelector('.cus-id-select').value;
                fetch('api/area-measurement-sheet/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            biIdInput,
                            biPay50Input,
                            biPay30Input,
                            biPay20Input,
                            biStatus50Input,
                            biStatus30Input,
                            biStatus20Input,
                            biDatePay50Input,
                            biDatePay30Input,
                            biDatapay20Input,
                            cusIdSelect
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
                    fetch('api/area-measurement-sheet/delete.php', {
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