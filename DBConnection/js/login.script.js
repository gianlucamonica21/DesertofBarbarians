document.getElementById("loginform").onsubmit = function () {
	var x = document.forms["loginform"]["login"].value;
	var y = document.forms["loginform"]["password"].value;
	var submit = true;

	if (x == null || x == "") {
		nameError = '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Please enter your login!</div>';
		document.getElementById("login_error").innerHTML = nameError;
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

document.getElementById("login").onkeyup = removeWarning;
document.getElementById("password").onkeyup = removeWarning;