// Initialize Flatpickr
flatpickr("#datepicker", {
  dateFormat: "Y-m-d", // Date format
});

function filter() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 2; i < tr.length; i++) {
    // Start from 1 to skip the header row
    var found = false;
    td = tr[i].getElementsByTagName("td");
    for (j = 0; j < td.length; j++) {
      txtValue = td[j].textContent || td[j].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        found = true;
        break;
      }
    }
    if (found) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}

function validateFormControls(tr) {
  const formControls = tr.querySelectorAll(".form-control");
  formControls.forEach(function (control) {
    // Validate each form control
    if (control.required && control.value.trim() === "") {
      // If the control is empty, add is-invalid class
      control.classList.add("is-invalid");
    } else {
      // If the control is not empty, remove is-invalid class and add is-valid class
      control.classList.remove("is-invalid");
      control.classList.add("is-valid");
    }
  });
  // Check if any of the form controls have invalid values
  const invalidControls = tr.querySelectorAll(".is-invalid");
  if (invalidControls.length > 0) {
    // If there are invalid controls, display an error message
    console.log("Validation failed!");
    Swal.fire({
      icon: "warning",
      text: "Please fill in required field.",
    });
    return false; // Validation failed
  }

  return true; // Validation passed
}
