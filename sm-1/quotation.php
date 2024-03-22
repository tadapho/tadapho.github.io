<?php
require_once "src/Controllers/ConnectController.php";

$quotation = array();

// $stmt = $PDOconn->prepare("SELECT Quotation.*, Managment_Quottaiont_Employee.*, Employee.*
//                             FROM Quotation
//                             LEFT JOIN Managment_Quottaiont_Employee ON Quotation.Quot_ID = Managment_Quottaiont_Employee.Quot_ID
//                             LEFT JOIN Employee ON Managment_Quottaiont_Employee.Emp_ID = Employee.Emp_ID ");
$stmt = $PDOconn->prepare("SELECT Quotation.*, Material_Use.M_SKU, Material_Use.Use_num, Managment_Quottaiont_Employee.Emp_ID
                            FROM Quotation
                            LEFT JOIN Material_Use ON Quotation.Quot_ID = Material_Use.Quot_ID 
                            LEFT JOIN Managment_Quottaiont_Employee ON Quotation.Quot_ID = Managment_Quottaiont_Employee.Quot_ID 
                            -- LEFT JOIN Quot_Cus ON Quotation.Cus_ID = Quot_Cus.Cus_ID 
                            -- LEFT JOIN Bill ON Quotation.Bill_ID = Bill.Bill_ID
                            ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $quotation[] = $row;
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

$employee = array();
$stmt = $PDOconn->prepare("SELECT * FROM Employee");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $employee[] = $row;
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

$bill = array();
$stmt = $PDOconn->prepare("SELECT * FROM Bill");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $bill[] = $row;
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
                    <a class="nav-link active" aria-current="page" href="#">Quotation</a>
                    <a class="nav-link" href="customer.php">Customer</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <h1>Quotation Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>เลขที่ใบเสนอราคา</th>
                    <th>ราคาสุทธิ</th>
                    <th>วันที่ออกใบเสนอราคา</th>
                    <th>รายละเอียดใบเสนอราคา</th>
                    <th>รหัสวัสดุ</th>
                    <th>จำนวนวัสดุที่ใช้</th>
                    <th>ลูกค้า</th>
                    <th>งาน</th>
                    <th>เลขใบเสร็จ</th>
                    <th>รหัสพนักงาน</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control quo-id-input" maxlength="4" required />
                    </td>
                    <td>
                        <input type="number" class="form-control quo-netprice-input" />
                    </td>
                    <td>
                        <input type="text" id="datepicker" class="form-control quo-date-input" placeholder="เลือกวันที่ ..">
                    </td>
                    <td>
                        <input class="form-control quo-detail-input" maxlength="100" />
                    </td>
                    <td>
                        <select class="form-select ma-sku-select">
                            <option value=""></option>
                            <?php foreach ($material as $ma) : ?>
                                <option value="<?= $ma->M_SKU; ?>"><?= $ma->M_SKU  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-control use-num-input" /></td>
                    <td>
                        <select class="form-select cus-id-select">
                            <option value=""></option>
                            <?php foreach ($customer as $cus) { ?>
                                <option value="<?= $cus->Cus_ID ?>"><?= $cus->Cus_ID ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td>
                        <select class="form-select bill-id-select">
                            <option value=""></option>
                            <?php foreach ($bill as $bi) { ?>
                                <option value="<?= $bi->Bill_ID ?>"><?= $bi->Bill_ID ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-select emp-id-select">
                            <option value=""></option>
                            <?php foreach ($employee as $emp) { ?>
                                <option value="<?= $emp->Emp_ID ?>"><?= $emp->Emp_ID  ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($quotation as $quo) {
                ?>
                    <tr>
                        <td>
                            <span><?= $quo->Quot_ID ?></span>
                            <input class="form-control quo-id-input" maxlength="4" value="<?= $quo->Quot_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $quo->Net_Price ?></span>
                            <input type="number" class="form-control quo-netprice-input" value="<?= $quo->Net_Price ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $quo->Quot_date ?></span>
                            <input type="text" id="datepicker" class="form-control quo-date-input" value="<?= $quo->Quot_date ?>" placeholder="เลือกวันที่ .." style="display: none;" />
                        </td>
                        <td>
                            <span><?= $quo->Quot_detail ?></span>
                            <input class="form-control quo-detail-input" maxlength="100" value="<?= $quo->Quot_detail ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $quo->M_SKU ?></span>
                            <select class="form-select ma-sku-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($material as $ma) : ?>
                                    <option value="<?= $ma->M_SKU; ?>" <?= ($ma->M_SKU == $quo->M_SKU) ? 'selected' : '' ?>><?= $ma->M_SKU  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <span><?= $quo->Use_num ?></span>
                            <input type="number" class="form-control use-num-input" value="<?= $quo->Use_num ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $quo->Cus_ID ?>
                            </span>
                            <select class="form-select cus-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($customer as $cus) : ?>
                                    <option value="<?= $cus->Cus_ID; ?>" <?= ($cus->Cus_ID == $quo->Cus_ID) ? 'selected' : '' ?>><?= $quo->Cus_ID  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?= $quo->Project_ID ?></td>
                        <td><?= $quo->Bill_ID ?></td>
                        <td>
                            <span>
                                <?php foreach ($employee as $emp) { ?>
                                    <?= ($emp->Emp_ID == $quo->Emp_ID) ? $emp->Emp_ID : '' ?>
                                <?php } ?>
                            </span>
                            <select class="form-select emp-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($employee as $emp) : ?>
                                    <option value="<?= $emp->Emp_ID; ?>" <?= ($emp->Emp_ID == $quo->Emp_ID) ? 'selected' : '' ?>><?= $emp->Emp_ID ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $quo->Quot_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $quo->Quot_ID ?>" style="display: none;">Save</button>
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
            const quoIdInput = tr.querySelector('.quo-id-input').value;
            const quoNetpriceInput = tr.querySelector('.quo-netprice-input').value;
            const quoDateInput = tr.querySelector('.quo-date-input').value;
            const quoDetailInput = tr.querySelector('.quo-detail-input').value;
            const cusIdSelect = tr.querySelector('.cus-id-select').value;
            const billIdSelect = tr.querySelector('.bill-id-select').value;
            const empIdSelect = tr.querySelector('.emp-id-select').value;
            // emp-id-select
            fetch('api/quotation/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        quoIdInput,
                        quoNetpriceInput,
                        quoDateInput,
                        quoDetailInput,
                        cusIdSelect,
                        billIdSelect,
                        empIdSelect
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        // throw new Error(JSON.stringify({
                        //     title: 'ขออภัย !',
                        //     message: 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้งในภายหลัง',
                        //     icon: 'error',
                        //     status: response.status
                        // }));
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
                            // window.location.reload();
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
                const quoIdInput = tr.querySelector('.quo-id-input').value;
                const quoNetpriceInput = tr.querySelector('.quo-netprice-input').value;
                const quoDateInput = tr.querySelector('.quo-date-input').value;
                const quoDetailInput = tr.querySelector('.quo-detail-input').value;
                const empIdSelect = tr.querySelector('.emp-id-select').value;
                fetch('api/quotation/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            quoIdInput,
                            quoNetpriceInput,
                            quoDateInput,
                            quoDetailInput,
                            empIdSelect
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
                    fetch('api/quotation/delete.php', {
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

<!-- <script>
    // Add event listener to all insert buttons
    const insertButtons = document.getElementById('insert-btn');
    insertButtons.addEventListener('click', function() {
        // Show SweetAlert2 popup with form
        Swal.fire({
            title: 'Insert Quotation',
            html: `<form id="insertForm" class="needs-validation text-start" novalidate>
                            <div class="form-group mb-2">
                                <label for="Net_Price">ราคาสุทธิ <span class="text-danger">*</span></label>
                                <input type="number" id="Net_Price" class="form-control" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Quot_date">วันที่ออกใบเสนอราคา <span class="text-danger">*</span></label>
                                <input type="text" id="Quot_date" class="form-control" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                        </form>`,
            confirmButtonText: 'Submit',
            focusConfirm: false,
            preConfirm: () => {
                const form = document.getElementById('insertForm');
                if (!form.checkValidity()) {
                    // Find the first invalid input element, Set the focus.
                    var firstInvalidInput = form.querySelector(':invalid');
                    if (firstInvalidInput) {
                        firstInvalidInput.focus();
                    }
                    form.classList.add('was-validated');
                    return false;
                }
                // Your code for handling the form submission goes here
                const Net_Price = document.getElementById('Net_Price').value;
                const Quot_date = document.getElementById('Quot_date').value;
                return {
                    Net_Price: Net_Price,
                    Quot_date: Quot_date
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form data to server for processing
                console.log(result.value); // Log form data
                fetch('api/quotation/insert.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            Net_Price: result.value.Net_Price,
                            Quot_date: result.value.Quot_date
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            hideLoading();
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
                                // window.location.reload();
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
    })
</script> -->

</html>