document.getElementById("login-form").onsubmit = function () {
	var username = document.forms["login-form"]["lg_username"].value;
	var password = document.forms["login-form"]["lg_password"].value;
	var submit = true;

	if (username == null || username == "" || password == null || password == "") {
		errorMsg = 'Both fields are required!';
		var errorMessageElement = document.getElementsByClassName("login-form-main-message");
		errorMessageElement[0].classList.add("show","error");
		errorMessageElement[0].innerHTML = errorMsg;

		submit = false;
	}

	return submit;
}

function removeWarning() {
	document.getElementsByClassName("login-form-main-message")[0].innerHTML = null;
	var errorMessageElement = document.getElementsByClassName("login-form-main-message")[0];
	errorMessageElement.classList.remove("show","error");
}

document.getElementById("lg_username").onkeyup = removeWarning;
document.getElementById("lg_password").onkeyup = removeWarning;