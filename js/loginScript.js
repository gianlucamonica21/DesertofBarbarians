document.getElementById("login-form").onsubmit = function (event) {
	event.preventDefault();
	var username = document.forms["login-form"]["lg_username"].value;
	var password = document.forms["login-form"]["lg_password"].value;

	if (username === "" || password === "") {
		errorMsg = 'Both fields are required!';
		var errorMessageElement = document.getElementsByClassName("login-form-main-message");
		errorMessageElement[0].classList.add("show","error");
		errorMessageElement[0].innerHTML = errorMsg;

	} else {
		$.ajax({
			type: "POST",
			url: "checkLogin.php",
			data: "username=" + username + "&password=" + password,
			dataType: 'text',
			success: function (response) {
				console.log("HI:00");
				//window.location("index.php");
				window.location.href = "index.php";
				return;
			},
			error: function (xhr, status, error) {
  			var err = "";//eval("(" + xhr.responseText + ")");
        console.log('jqXHR:');
        console.log(xhr);
        console.log('textStatus:');
        console.log(status);
        console.log('errorThrown:');
        console.log(err);
        errorMsg = xhr.responseText;
				var errorMessageElement = document.getElementsByClassName("login-form-main-message");
				errorMessageElement[0].classList.add("show","error");
				errorMessageElement[0].innerHTML = errorMsg;
       }
		});
	}

}

function removeWarning() {
	document.getElementsByClassName("login-form-main-message")[0].innerHTML = null;
	var errorMessageElement = document.getElementsByClassName("login-form-main-message")[0];
	errorMessageElement.classList.remove("show","error");
}

document.getElementById("lg_username").onkeyup = removeWarning;
document.getElementById("lg_password").onkeyup = removeWarning;