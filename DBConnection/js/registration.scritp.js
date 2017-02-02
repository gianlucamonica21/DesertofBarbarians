 document.getElementById("registration").onsubmit = function () {
  var x = document.forms["registration"]["username"].value;
  var y = document.forms["registration"]["password"].value;
  var submit = true;

  if (x == null || x == "") {
    nameError = '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Please enter your username!</div>';
    document.getElementById("username_error").innerHTML = nameError;
    submit = false;
  }

  if (y == null || y == "") {
    passError = '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Please enter your password!</div>';
    document.getElementById("password_error").innerHTML = passError;
    submit = false;
  }

  

  return submit;
}

function removeWarning() {
  document.getElementById(this.id + "_error").innerHTML = "";
}

document.getElementById("username").onkeyup = removeWarning;
document.getElementById("password").onkeyup = removeWarning;