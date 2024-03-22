<?php
require_once "src/Controllers/ConnectController.php";

$supplier = array();

$stmt = $PDOconn->prepare("SELECT Supplier.*, Project.Project_ID
                            FROM Supplier
                            LEFT JOIN Project ON Supplier.Project_ID = Project.Project_ID ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $supplier[] = $row;
    }
}

$project = array();
$stmt = $PDOconn->prepare("SELECT * FROM Project");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $project[] = $row;
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
        <h1>Supplier Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>รหัสซัพพลายเออร์</th>
                    <th>ชื่อ</th>
                    <th>เบอร์โทร</th>
                    <th>เลขที่ตั้ง</th>
                    <th>ถนน</th>
                    <th>จังหวัด</th>
                    <th>รหัสไปรษณีย์</th>
                    <th>รหัสงาน</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control sup-id-input" maxlength="3" required />
                    </td>
                    <td>
                        <input class="form-control sup-name-input" maxlength="50" required />
                    </td>
                    <td>
                        <input class="form-control sup-tel-input" maxlength="11" />
                    </td>
                    <td>
                        <input class="form-control sup-hno-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control sup-street-input" maxlength="18" />
                    </td>
                    <td>
                        <input class="form-control sup-city-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control sup-zipcode-input" maxlength="5" />
                    </td>
                    <td>
                        <select class="form-select sup-project-select">
                            <option value=""></option>
                            <?php foreach ($project as $pro) : ?>
                                <option value="<?= $pro->Project_ID; ?>"><?= $pro->Project_ID ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($supplier as $sup) {
                ?>
                    <tr>
                        <td>
                            <span><?= $sup->Sup_ID ?></span>
                            <input class="form-control sup-id-input" maxlength="3" value="<?= $sup->Sup_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_name ?></span>
                            <input class="form-control sup-name-input" maxlength="50" value="<?= $sup->Sup_name ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_Tel ?></span>
                            <input class="form-control sup-tel-input" maxlength="11" value="<?= $sup->Sup_Tel ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_HNo ?></span>
                            <input class="form-control sup-hno-input" maxlength="12" value="<?= $sup->Sup_city ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_street ?></span>
                            <input class="form-control sup-street-input" maxlength="18" value="<?= $sup->Sup_street ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_city ?></span>
                            <input class="form-control sup-city-input" maxlength="12" value="<?= $sup->Sup_city ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Sup_zipcode ?></span>
                            <input class="form-control sup-zipcode-input" maxlength="5" value="<?= $sup->Sup_zipcode ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $sup->Project_ID ?> </span>
                            <select class="form-select sup-project-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($project as $pro) : ?>
                                    <option value="<?= $pro->Project_ID; ?>" <?= ($pro->Project_ID == $sup->Project_ID) ? 'selected' : '' ?>><?= $pro->Project_ID ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $sup->Sup_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $sup->Sup_ID ?>" style="display: none;">Save</button>
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
            const supIdInput = tr.querySelector('.sup-id-input').value;
            const supNameInput = tr.querySelector('.sup-name-input').value;
            const supTelInput = tr.querySelector('.sup-tel-input').value;
            const supHnoInput = tr.querySelector('.sup-hno-input').value;
            const supStreetInput = tr.querySelector('.sup-street-input').value;
            const supZipcodeInput = tr.querySelector('.sup-zipcode-input').value;
            const supCityInput = tr.querySelector('.sup-city-input').value;
            const supProjectSelect = tr.querySelector('.sup-project-select').value;
            fetch('api/supplier/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        supIdInput,
                        supNameInput,
                        supTelInput,
                        supHnoInput,
                        supStreetInput,
                        supZipcodeInput,
                        supCityInput,
                        supProjectSelect
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
                const supIdInput = tr.querySelector('.sup-id-input').value;
                const supNameInput = tr.querySelector('.sup-name-input').value;
                const supTelInput = tr.querySelector('.sup-tel-input').value;
                const supHnoInput = tr.querySelector('.sup-hno-input').value;
                const supStreetInput = tr.querySelector('.sup-street-input').value;
                const supZipcodeInput = tr.querySelector('.sup-zipcode-input').value;
                const supCityInput = tr.querySelector('.sup-city-input').value;
                const supProjectSelect = tr.querySelector('.sup-project-select').value;
                fetch('api/supplier/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            supIdInput,
                            supNameInput,
                            supTelInput,
                            supHnoInput,
                            supStreetInput,
                            supZipcodeInput,
                            supCityInput,
                            supProjectSelect
                        })
                    })
                    .then(response => {
                        // if (!response.ok) {
                        //     throw new Error(JSON.stringify({
                        //         title: 'ขออภัย !',
                        //         message: 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้งในภายหลัง',
                        //         icon: 'error',
                        //         status: response.status
                        //     }));
                        // }
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
                    fetch('api/supplier/delete.php', {
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