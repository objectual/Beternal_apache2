<!DOCTYPE html>
<html lang="en">
 <head>
   <title>International telephone input</title>
   <meta name="viewport" content="width=device-width, initial-scale=1" />
 </head>
 <body>
 <div class="container">
 <input id="phone" type="tel">
<span id="valid-msg" class="hide">✓ Valid</span>
<span id="error-msg" class="hide"></span>
</div>
 </body>
 <script>
   var input = document.querySelector("#phone"),
  errorMsg = document.querySelector("#error-msg"),
  validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
  utilsScript: "../../build/js/utils.js?1638200991544"
});

var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);

 </script>
</html>