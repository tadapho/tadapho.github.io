<?php
require_once "src/Controllers/ConnectController.php";

$area_measurement_sheet = array();

$stmt = $PDOconn->prepare("SELECT Area_Measurement_Sheet.*, Material_Area_Measurement_Sheet.M_SKU, Quotation.Quot_ID, AMS_Project.*
                            FROM Area_Measurement_Sheet
                            LEFT JOIN Material_Area_Measurement_Sheet ON Area_Measurement_Sheet.AMS_ID = Material_Area_Measurement_Sheet.AMS_ID 
                            LEFT JOIN AMS_Project ON Area_Measurement_Sheet.AMS_ID = AMS_Project.AMS_ID
                            LEFT JOIN Quotation ON Area_Measurement_Sheet.Quot_ID = Quotation.Quot_ID ");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $area_measurement_sheet[] = $row;
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

$project = array();
$stmt = $PDOconn->prepare("SELECT * FROM Project");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $project[] = $row;
    }
}

$quotation = array();
$stmt = $PDOconn->prepare("SELECT * FROM Quotation");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
if ($result) {
    foreach ($result as $row) {
        $quotation[] = $row;
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
                    <a class="nav-link" href="customer.php">Customer</a>
                    <a class="nav-link" href="project.php">Project</a>
                    <a class="nav-link" href="supplier.php">Supplier</a>
                    <a class="nav-link" href="material.php">Material</a>
                    <a class="nav-link" href="production_order.php">Production-Order</a>
                    <a class="nav-link active" aria-current="page" href="#">Area-measurement-sheet</a>
                    <a class="nav-link" href="bill.php">Bill</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid glassmorphism-light shadow my-5 px-4 py-4">
        <input type="text" id="myInput" class="form-control mb-5" onkeyup="filter()" placeholder="ค้นหา">
        <h1>Area Measurement Sheet Table</h1>
        <div class="text-end"><button class="btn btn-success" id="insert-btn">Insert</button></div>
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr class="table-primary">
                    <th>เลขที่ใบวัดหน้างาน</th>
                    <th>ช่วงเวลา</th>
                    <th>วันที่วัด</th>
                    <th>เลขที่บ้าน</th>
                    <th>ถนน</th>
                    <th>จังหวัด</th>
                    <th>รหัสไปรษณีย์</th>
                    <th>รหัสงาน</th>
                    <th>เลขที่ใบเสนอราคา</th>
                    <th>รหัสวัสดุ</th>
                    <th>ขนาดพื้นที่</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="insert-form" style="display: none;">
                    <td>
                        <input class="form-control area-id-input" maxlength="6" required />
                    </td>
                    <td>
                        <!-- <input class="form-control area-time-input" maxlength="4" /> -->
                        <select class="form-select area-time-input">
                            <option value=""></option>
                            <option value="เช้า">เช้า</option>
                            <option value="บ่าย">บ่าย</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="datepicker" class="form-control area-date-input" placeholder="ระบุ .." />
                    </td>
                    <td>
                        <input class="form-control area-hno-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control area-street-input" maxlength="18" />
                    </td>
                    <td>
                        <input class="form-control area-city-input" maxlength="12" />
                    </td>
                    <td>
                        <input class="form-control area-zipcode-input" maxlength="5" />
                    </td>
                    <td>
                        <select class="form-select project-id-select">
                            <option value=""></option>
                            <?php foreach ($project as $pro) : ?>
                                <option value="<?= $pro->Project_ID; ?>"><?= $pro->Project_ID  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-select quotation-id-select">
                            <option value=""></option>
                            <?php foreach ($quotation as $qu) : ?>
                                <option value="<?= $qu->Quot_ID; ?>"><?= $qu->Quot_ID  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-select material-id-select">
                            <option value=""></option>
                            <?php foreach ($material as $ma) : ?>
                                <option value="<?= $ma->M_SKU; ?>"><?= $ma->M_SKU  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input class="form-control area-measurement-input" maxlength="14" />
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success save-btn">Save</button>
                        <button class="btn btn-sm btn-warning cancel-btn">Cancel</button>
                    </td>
                </tr>
                <?php
                foreach ($area_measurement_sheet as $area) {
                ?>
                    <tr>
                        <td>
                            <span><?= $area->AMS_ID ?></span>
                            <input class="form-control area-id-input" maxlength="6" value="<?= $area->AMS_ID ?>" style="display: none;" required />
                        </td>
                        <td>
                            <span><?= $area->AMS_time ?></span>
                            <!-- <input class="form-control area-time-input" maxlength="4" value="<?= $area->AMS_time ?>" style="display: none;" /> -->
                            <select class="form-select area-time-input" style="display: none;">
                                <option value=""></option>
                                <option value="เช้า" <?= ($area->AMS_time == "เช้า") ? 'selected' : '' ?>>เช้า</option>
                                <option value="บ่าย" <?= ($area->AMS_time == "บ่าย") ? 'selected' : '' ?>>บ่าย</option>
                            </select>
                        </td>
                        <td>
                            <span><?= date('d/m/Y', strtotime($area->AMS_date)) ?></span>
                            <input type="text" id="datepicker" class="form-control area-date-input" value="<?= $area->AMS_date ?>" placeholder="ระบุ .." style="display: none;" />
                        </td>
                        <td>
                            <span><?= $area->Loc_HNo ?></span>
                            <input class="form-control area-hno-input" maxlength="12" value="<?= $area->Loc_HNo ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $area->Loc_street ?></span>
                            <input class="form-control area-street-input" maxlength="18" value="<?= $area->Loc_street ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $area->Loc_city ?></span>
                            <input class="form-control area-city-input" maxlength="12" value="<?= $area->Loc_city ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $area->loc_zipcode ?></span>
                            <input class="form-control area-zipcode-input" maxlength="5" value="<?= $area->loc_zipcode ?>" style="display: none;" />
                        </td>
                        <td>
                            <span><?= $area->Project_ID ?>
                            </span>
                            <select class="form-select project-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($project as $pro) : ?>
                                    <option value="<?= $pro->Project_ID; ?>" <?= ($pro->Project_ID == $area->Project_ID) ? 'selected' : '' ?>><?= $pro->Project_ID  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <span><?= $area->Quot_ID ?>
                            </span>
                            <select class="form-select quotation-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($quotation as $qu) : ?>
                                    <option value="<?= $qu->Quot_ID; ?>" <?= ($qu->Quot_ID == $area->Quot_ID) ? 'selected' : '' ?>><?= $qu->Quot_ID  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <span><?= $area->M_SKU ?>
                            </span>
                            <select class="form-select material-id-select" style="display: none;">
                                <option value=""></option>
                                <?php foreach ($material as $ma) : ?>
                                    <option value="<?= $ma->M_SKU; ?>" <?= ($ma->M_SKU == $area->M_SKU) ? 'selected' : '' ?>><?= $ma->M_SKU  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <span><?= $area->Measurement ?></span>
                            <input class="form-control area-measurement-input" maxlength="14" value="<?= $area->Measurement ?>" style="display: none;" />
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-danger del-btn" value="<?= $area->AMS_ID ?>">Delete</button>
                            <button class="btn btn-sm btn-success save-btn" value="<?= $area->AMS_ID ?>" style="display: none;">Save</button>
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
            const areaIdInput = tr.querySelector('.area-id-input').value;
            const areaTimeInput = tr.querySelector('.area-time-input').value;
            const areaDateInput = tr.querySelector('.area-date-input').value;
            const areaHnoInput = tr.querySelector('.area-hno-input').value;
            const areaStreetInput = tr.querySelector('.area-street-input').value;
            const areaCityInput = tr.querySelector('.area-city-input').value;
            const areaZipcodeInput = tr.querySelector('.area-zipcode-input').value;
            const projectIdSelect = tr.querySelector('.project-id-select').value;
            const quotationIdSelect = tr.querySelector('.quotation-id-select').value;
            const materialIdSelect = tr.querySelector('.material-id-select').value;
            const areaMeasurementInput = tr.querySelector('.area-measurement-input').value;
            fetch('api/area-measurement-sheet/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        areaIdInput,
                        areaTimeInput,
                        areaDateInput,
                        areaHnoInput,
                        areaStreetInput,
                        areaCityInput,
                        areaZipcodeInput,
                        projectIdSelect,
                        quotationIdSelect,
                        materialIdSelect,
                        areaMeasurementInput
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
                const areaIdInput = tr.querySelector('.area-id-input').value;
                const areaTimeInput = tr.querySelector('.area-time-input').value;
                const areaDateInput = tr.querySelector('.area-date-input').value;
                const areaHnoInput = tr.querySelector('.area-hno-input').value;
                const areaStreetInput = tr.querySelector('.area-street-input').value;
                const areaCityInput = tr.querySelector('.area-city-input').value;
                const areaZipcodeInput = tr.querySelector('.area-zipcode-input').value;
                const projectIdSelect = tr.querySelector('.project-id-select').value;
                const quotationIdSelect = tr.querySelector('.quotation-id-select').value;
                const materialIdSelect = tr.querySelector('.material-id-select').value;
                const areaMeasurementInput = tr.querySelector('.area-measurement-input').value;
                fetch('api/area-measurement-sheet/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ID: this.value,
                            areaIdInput,
                            areaTimeInput,
                            areaDateInput,
                            areaHnoInput,
                            areaStreetInput,
                            areaCityInput,
                            areaZipcodeInput,
                            projectIdSelect,
                            quotationIdSelect,
                            materialIdSelect,
                            areaMeasurementInput
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