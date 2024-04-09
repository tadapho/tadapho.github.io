<?php
require_once "src/Controllers/ConnectController.php";

$customer = array();

$stmt = $PDOconn->prepare("SELECT Customer.*, Employee.*
                            FROM Customer
                            LEFT JOIN Employee ON Customer.Emp_ID = Employee.Emp_ID ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $customer[] = $row;
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
                    <a class="nav-link active" aria-current="page" href="#">Customer</a>
                    <a class="nav-link" href="project.php">Project</a>
                    <a class="nav-link" href="supplier.php">Supplier</a>
                    <a class="nav-link" href="material.php">Material</a>
                    <a class="nav-link" href="production_order.php">Production-Order</a>
                    <a class="nav-link " href="area-measurement-sheet.php">Area-measurement-sheet</a>
                    <a class="nav-link" href="bill.php">Bill</a>

                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <input type="text" id="myInput" class="form-control mb-5" onkeyup="filter()" placeholder="ค้นหา">
        <h1>Customer Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr class="table-primary">
                    <th>รหัสลูกค้า</th>
                    <th>ชื่อลูกค้า</th>
                    <th>นามสกุลลูกค้า</th>
                    <th>เบอร์โทร</th>
                    <th>ช่องทางการติดต่อ</th>
                    <th>บ้านเลขที่</th>
                    <th>จังหวัด</th>
                    <th>ถนน</th>
                    <th>รหัสไปรษณีย์</th>
                    <th>รหัสพนักงาน</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control cus-id-input" maxlength="4" required />
                    </td>
                    <td>
                        <input class="form-control cus-fname-input" maxlength="18" required />
                    </td>
                    <td>
                        <input class="form-control cus-lname-input" maxlength="18" required />
                    </td>
                    <td>
                        <input class="form-control cus-tel-input" maxlength="11" />
                    </td>
                    <td>
                        <input class="form-control cus-content-input" maxlength="9" />
                    </td>
                    <td>
                        <input class="form-control cus-hno-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control cus-city-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control cus-street-input" maxlength="18" />
                    </td>
                    <td>
                        <input class="form-control cus-zipcode-input" maxlength="5" />
                    </td>
                    <td>
                        <select class="form-select emp-id-select">
                            <option value=""></option>
                            <?php foreach ($employee as $emp) : ?>
                                <option value="<?= $emp->Emp_ID; ?>"><?= $emp->Emp_ID ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($customer as $cus) {
                ?>
                    <tr>
                        <td>
                            <span><?= $cus->Cus_ID ?></span>
                            <input class="form-control cus-id-input" maxlength="4" value="<?= $cus->Cus_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $cus->Cus_Fname ?></span>
                            <input class="form-control cus-fname-input" maxlength="18" value="<?= $cus->Cus_Fname ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $cus->Cus_Lname ?></span>
                            <input class="form-control cus-lname-input" maxlength="18" value="<?= $cus->Cus_Lname ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $cus->Cus_Tel ?></span>
                            <input class="form-control cus-tel-input" maxlength="11" value="<?= $cus->Cus_Tel ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $cus->Cus_Content ?></span>
                            <input class="form-control cus-content-input" maxlength="9" value="<?= $cus->Cus_Content ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $cus->Cus_HNo ?></span>
                            <input class="form-control cus-hno-input" maxlength="12" value="<?= $cus->Cus_HNo ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $cus->Cus_city ?></span>
                            <input class="form-control cus-city-input" maxlength="12" value="<?= $cus->Cus_city ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $cus->Cus_street ?></span>
                            <input class="form-control cus-street-input" maxlength="18" value="<?= $cus->Cus_street ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $cus->Cus_zipcode ?></span>
                            <input class="form-control cus-zipcode-input" maxlength="5" value="<?= $cus->Cus_zipcode ?>" style="display: none;" />
                        </td>
                        <td>
                            <span>
                                <?= $cus->Emp_ID ?>
                            </span>
                            <select class="form-select emp-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($employee as $emp) : ?>
                                    <option value="<?= $emp->Emp_ID; ?>" <?= ($emp->Emp_ID == $cus->Emp_ID) ? 'selected' : '' ?>><?= $emp->Emp_ID ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $cus->Cus_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $cus->Cus_ID ?>" style="display: none;">Save</button>
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
            const cusIdInput = tr.querySelector('.cus-id-input').value;
            const cusFnameInput = tr.querySelector('.cus-fname-input').value;
            const cusLnameInput = tr.querySelector('.cus-lname-input').value;
            const cusTelInput = tr.querySelector('.cus-tel-input').value;
            const cusContentInput = tr.querySelector('.cus-content-input').value;
            const cusHnoInput = tr.querySelector('.cus-hno-input').value;
            const cusCityInput = tr.querySelector('.cus-city-input').value;
            const cusStreetInput = tr.querySelector('.cus-street-input').value;
            const cusZipcodeInput = tr.querySelector('.cus-zipcode-input').value;
            const empIdSelect = tr.querySelector('.emp-id-select').value;
            fetch('api/customer/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        cusIdInput,
                        cusFnameInput,
                        cusLnameInput,
                        cusTelInput,
                        cusContentInput,
                        cusHnoInput,
                        cusCityInput,
                        cusStreetInput,
                        cusZipcodeInput,
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
                const cusIdInput = tr.querySelector('.cus-id-input').value;
                const cusFnameInput = tr.querySelector('.cus-fname-input').value;
                const cusLnameInput = tr.querySelector('.cus-lname-input').value;
                const cusTelInput = tr.querySelector('.cus-tel-input').value;
                const cusContentInput = tr.querySelector('.cus-content-input').value;
                const cusHnoInput = tr.querySelector('.cus-hno-input').value;
                const cusCityInput = tr.querySelector('.cus-city-input').value;
                const cusStreetInput = tr.querySelector('.cus-street-input').value;
                const cusZipcodeInput = tr.querySelector('.cus-zipcode-input').value;
                const empIdSelect = tr.querySelector('.emp-id-select').value;
                fetch('api/customer/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            cusIdInput,
                            cusFnameInput,
                            cusLnameInput,
                            cusTelInput,
                            cusContentInput,
                            cusHnoInput,
                            cusCityInput,
                            cusStreetInput,
                            cusZipcodeInput,
                            cusZipcodeInput,
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
                    fetch('api/customer/delete.php', {
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