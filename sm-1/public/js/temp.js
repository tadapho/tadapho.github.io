<script>
    // Add event listener to all insert buttons
    const insertButtons = document.getElementById('insert-btn');
    insertButtons.addEventListener('click', function() {
        // Show SweetAlert2 popup with form
        Swal.fire({
            title: 'Insert Employee',
            html: `<form id="insertForm" class="needs-validation text-start" novalidate>
                            <div class="form-group mb-2">
                                <label for="empFname">ชื่อ <span class="text-danger">*</span></label>
                                <input type="text" id="empFname" class="form-control" maxlength="18" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empLname">นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" id="empLname" class="form-control" maxlength="18" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empTel">เบอร์โทร</label>
                                <input type="text" id="empTel" class="form-control" maxlength="11">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empRole">ตำแหน่ง</label>
                                <input type="text" id="empRole" class="form-control" maxlength="18">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empSalary">เงินเดือน</label>
                                <input type="number" id="empSalary" class="form-control">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_HNo">เลขที่บ้าน</label>
                                <input type="text" id="Emp_HNo" class="form-control" maxlength="12">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_city">จังหวัด</label>
                                <input type="text" id="Emp_city" class="form-control" maxlength="12">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_street">ถนน</label>
                                <input type="text" id="Emp_street" class="form-control" maxlength="18">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_zipcode">รหัสไปรษณีย์</label>
                                <input type="text" id="Emp_zipcode" class="form-control" maxlength="5">
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
                const Emp_Fname = document.getElementById('empFname').value;
                const Emp_Lname = document.getElementById('empLname').value;
                const Emp_Tel = document.getElementById('empTel').value;
                const Emp_role = document.getElementById('empRole').value;
                const Emp_salary = document.getElementById('empSalary').value;
                return {
                    Emp_ID: empID,
                    Emp_Fname: Emp_Fname,
                    Emp_Lname: Emp_Lname,
                    Emp_Tel: Emp_Tel,
                    Emp_role: Emp_role,
                    Emp_salary: Emp_salary
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form data to server for processing
                console.log(result.value); // Log form data
                fetch('api/employee/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            Emp_ID: result.value.Emp_ID,
                            Emp_Fname: result.value.Emp_Fname,
                            Emp_Lname: result.value.Emp_Lname
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

    // Add event listener to all edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Get the row data
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            // Extract data from cells
            const empID = button.getAttribute('data-empid');
            const empFname = cells[1].textContent.trim();
            const empLname = cells[2].textContent.trim();
            const empTel = cells[3].textContent.trim();
            const empRole = cells[4].textContent.trim();
            const empSalary = cells[5].textContent.trim();
            const empHNo = cells[6].textContent.trim();
            const empCity = cells[7].textContent.trim();
            const empStreet = cells[8].textContent.trim();
            const empZipcode = cells[9].textContent.trim();
            const empManager = cells[10].textContent.trim();
            // Show SweetAlert2 popup with form
            Swal.fire({
                title: 'Edit Employee',
                html: `<form id="editForm" class="needs-validation text-start" novalidate>
                            <div class="form-group mb-2">
                                <label for="empFname">ชื่อ <span class="text-danger">*</span></label>
                                <input type="text" id="empFname" class="form-control" value="${empFname}" maxlength="18" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empLname">นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" id="empLname" class="form-control" value="${empLname}" maxlength="18" required>
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empTel">เบอร์โทร</label>
                                <input type="text" id="empTel" class="form-control" value="${empTel}" maxlength="11">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empRole">ตำแหน่ง</label>
                                <input type="text" id="empRole" class="form-control" value="${empRole}" maxlength="18">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="empSalary">เงินเดือน</label>
                                <input type="number" id="empSalary" class="form-control" value="${empSalary}">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_HNo">เลขที่บ้าน</label>
                                <input type="text" id="Emp_HNo" class="form-control" value="${empHNo}" maxlength="12">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_city">จังหวัด</label>
                                <input type="text" id="Emp_city" class="form-control" value="${empCity}" maxlength="12">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_street">ถนน</label>
                                <input type="text" id="Emp_street" class="form-control" value="${empStreet}" maxlength="18">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Emp_zipcode">รหัสไปรษณีย์</label>
                                <input type="text" id="Emp_zipcode" class="form-control" value="${empZipcode}" maxlength="5">
                                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
                            </div>
                        </form>`,
                confirmButtonText: 'Submit',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('editForm');
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
                    const Emp_Fname = document.getElementById('empFname').value;
                    const Emp_Lname = document.getElementById('empLname').value;
                    const Emp_Tel = document.getElementById('empTel').value;
                    const Emp_role = document.getElementById('empRole').value;
                    const Emp_salary = document.getElementById('empSalary').value;
                    return {
                        Emp_ID: empID,
                        Emp_Fname: Emp_Fname,
                        Emp_Lname: Emp_Lname,
                        Emp_Tel: Emp_Tel,
                        Emp_role: Emp_role,
                        Emp_salary: Emp_salary
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form data to server for processing
                    console.log(result.value); // Log form data
                    fetch('api/employee/update.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                Emp_ID: result.value.Emp_ID,
                                Emp_Fname: result.value.Emp_Fname,
                                Emp_Lname: result.value.Emp_Lname
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
        });
    });
</script>