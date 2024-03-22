<?php
require_once "src/Controllers/ConnectController.php";

$employee = array();
$stmt = $PDOconn->prepare("SELECT Employee.*, Department_Manager.*, Department.*
                            FROM Employee
                            LEFT JOIN Department_Manager ON Employee.Emp_manager = Department_Manager.Emp_manager
                            LEFT JOIN Department ON Department_Manager.Dept_ID = Department.Dept_ID
                            ORDER BY Employee.Emp_ID ASC");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $employee[$row->Emp_ID] = $row;
    }
}

$department_manager = array();
$stmt = $PDOconn->prepare("SELECT Department_Manager.*, Department.*
                            FROM Department_Manager
                            LEFT JOIN Department ON Department_Manager.Dept_ID = Department.Dept_ID
                            ORDER BY Department_Manager.Emp_manager ASC");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $department_manager[] = $row;
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
                    <a class="nav-link" href="department.php">Department</a>
                    <a class="nav-link" href="department_manager.php">Department-Management</a>
                    <a class="nav-link active" aria-current="page" href="#">Employee</a>
                    <a class="nav-link" href="quotation.php">Quotation</a>
                    <a class="nav-link" href="customer.php">Customer</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <h1>Employee Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เบอร์โทร</th>
                    <th>ตำแหน่ง</th>
                    <th>เงินเดือน</th>
                    <th>เลขที่บ้าน</th>
                    <th>จังหวัด</th>
                    <th>ถนน</th>
                    <th>รหัสไปรษณีย์</th>
                    <th>รหัสผู้จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control emp-id-input" maxlength="4" required />
                    </td>
                    <td>
                        <input class="form-control emp-fname-input" maxlength="18" required />
                    </td>
                    <td>
                        <input class="form-control emp-lname-input" maxlength="18" required />
                    </td>
                    <td>
                        <input class="form-control emp-tel-input" maxlength="11" />
                    </td>
                    <td>
                        <input class="form-control emp-role-input" maxlength="18" />
                    </td>
                    <td>
                        <input class="form-control emp-salary-input" type="number" />
                    </td>
                    <td>
                        <input class="form-control emp-hno-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control emp-city-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control emp-street-input" maxlength="18" />
                    </td>
                    <td>
                        <input class="form-control emp-zipcode-input" maxlength="5" />
                    </td>
                    <td>
                        <select class="form-select emp-manager-select">
                            <option value=""></option>
                            <?php foreach ($department_manager as $deptm) { ?>
                                <option value="<?= $deptm->Emp_manager ?>"><?= $deptm->Emp_manager . " : " . $deptm->Dept_name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($employee as $emp) {
                ?>
                    <tr>
                        <td>
                            <span><?= $emp->Emp_ID ?></span>
                            <input class="form-control emp-id-input" maxlength="4" value="<?= $emp->Emp_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $emp->Emp_Fname ?></span>
                            <input class="form-control emp-fname-input" maxlength="18" value="<?= $emp->Emp_Fname ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $emp->Emp_Lname ?></span>
                            <input class="form-control emp-lname-input" maxlength="18" value="<?= $emp->Emp_Lname ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $emp->Emp_Tel ?></span>
                            <input class="form-control emp-tel-input" maxlength="11" value="<?= $emp->Emp_Tel ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_role ?></span>
                            <input class="form-control emp-role-input" maxlength="18" value="<?= $emp->Emp_role ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_salary ?></span>
                            <input class="form-control emp-salary-input" type="number" value="<?= $emp->Emp_salary ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_HNo ?></span>
                            <input class="form-control emp-hno-input" maxlength="12" value="<?= $emp->Emp_HNo ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_city ?></span>
                            <input class="form-control emp-city-input" maxlength="12" value="<?= $emp->Emp_city ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_street ?></span>
                            <input class="form-control emp-street-input" maxlength="18" value="<?= $emp->Emp_street ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $emp->Emp_zipcode ?></span>
                            <input class="form-control emp-zipcode-input" maxlength="5" value="<?= $emp->Emp_zipcode ?>" style="display: none;" />
                        </td>
                        <td>
                            <span>
                                <?php foreach ($department_manager as $deptm) { ?>
                                    <?= ($emp->Dept_ID == $deptm->Dept_ID) ? $deptm->Emp_manager . " : " . $deptm->Dept_name : '' ?>
                                <?php } ?>
                            </span>
                            <select class="form-select emp-manager-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($department_manager as $deptm) { ?>
                                    <option value="<?= $deptm->Emp_manager ?>" <?= ($emp->Emp_manager == $deptm->Emp_manager) ? 'selected' : '' ?>>
                                        <?= $deptm->Emp_manager . " : " . $deptm->Dept_name ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $emp->Emp_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $emp->Emp_ID ?>" style="display: none;">Save</button>
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
            const empIdInput = tr.querySelector('.emp-id-input').value;
            const empFnameInput = tr.querySelector('.emp-fname-input').value;
            const empLnameInput = tr.querySelector('.emp-lname-input').value;
            const empTelInput = tr.querySelector('.emp-tel-input').value;
            const empRoleInput = tr.querySelector('.emp-role-input').value;
            const empSalaryInput = tr.querySelector('.emp-salary-input').value;
            const empHnoInput = tr.querySelector('.emp-hno-input').value;
            const empCityInput = tr.querySelector('.emp-city-input').value;
            const empStreetInput = tr.querySelector('.emp-street-input').value;
            const empZipcodeInput = tr.querySelector('.emp-zipcode-input').value;
            const empManagerSelect = tr.querySelector('.emp-manager-select').value;
            fetch('api/employee/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        empIdInput,
                        empFnameInput,
                        empLnameInput,
                        empTelInput,
                        empRoleInput,
                        empSalaryInput,
                        empHnoInput,
                        empCityInput,
                        empStreetInput,
                        empZipcodeInput,
                        empManagerSelect
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
                const empIdInput = tr.querySelector('.emp-id-input').value;
                const empFnameInput = tr.querySelector('.emp-fname-input').value;
                const empLnameInput = tr.querySelector('.emp-lname-input').value;
                const empTelInput = tr.querySelector('.emp-tel-input').value;
                const empRoleInput = tr.querySelector('.emp-role-input').value;
                const empSalaryInput = tr.querySelector('.emp-salary-input').value;
                const empHnoInput = tr.querySelector('.emp-hno-input').value;
                const empCityInput = tr.querySelector('.emp-city-input').value;
                const empStreetInput = tr.querySelector('.emp-street-input').value;
                const empZipcodeInput = tr.querySelector('.emp-zipcode-input').value;
                const empManagerSelect = tr.querySelector('.emp-manager-select').value;
                fetch('api/employee/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            empIdInput,
                            empFnameInput,
                            empLnameInput,
                            empTelInput,
                            empRoleInput,
                            empSalaryInput,
                            empHnoInput,
                            empCityInput,
                            empStreetInput,
                            empZipcodeInput,
                            empManagerSelect
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
                    fetch('api/employee/delete.php', {
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