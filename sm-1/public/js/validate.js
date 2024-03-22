// fetch all the inputs we want to apply custom style
var inputs = document.getElementsByClassName("form-control");
// loop over each input and watch blue event
var validation = Array.prototype.filter.call(inputs, function (input) {
  input.addEventListener(
    "input",
    function (event) {
      // reset
      input.classList.remove("is-invalid");
      input.classList.remove("is-valid");
      if (input.checkValidity() === false) {
        input.classList.add("is-invalid");
      } else {
        input.classList.add("is-valid");
      }
    },
    false
  );
});

// fetch all the selects we want to apply custom style
var selects = document.getElementsByClassName("form-select");
// Loop through all the select elements and add an event listener to each one
var validation = Array.prototype.filter.call(selects, function (select) {
  select.addEventListener(
    "change",
    function (event) {
      // reset
      select.classList.remove("is-invalid");
      select.classList.remove("is-valid");
      if (select.checkValidity() === false) {
        select.classList.add("is-invalid");
      } else {
        select.classList.add("is-valid");
      }
    },
    false
  );
});
