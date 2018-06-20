$(document).ready (function () {
	// Set the values to blank at the start
	document.forms["login-form"].reset ();
	document.forms["register-form"].reset ();
	
	$(function() {
		$('#login-form-link').click(function(e) {
			$("#login-form").delay(100).fadeIn(100);
			$("#register-form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		
		$('#register-form-link').click(function(e) {
			$("#register-form").delay(100).fadeIn(100);
			$("#login-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
	});
})

function validateLoginForm()
{
	var userid          = document.forms["login-form"]["userid"].value;
	var userid_regex    = /^[A-Za-z0-9]+$/;
	
	if (userid.length > 0)
	{
		if (!userid.match (userid_regex))
		{
			alert ("UserID is mandatory and only Alphanumeric");
			
			return false;
		}
	}
	else
	{
		alert ("UserID is mandatory");
		
		return false;
	}
}

function validateRegisterForm()
{
	var userid          = document.forms["register-form"]["userid"].value;
	var userid_regex    = /^[A-Za-z0-9]+$/;
	
	if (userid.length > 0)
	{
		if (!userid.match (userid_regex))
		{
			alert ("UserID is mandatory and only Alphanumeric");
			
			return false;
		}
	}
	else
	{
		alert ("UserID is mandatory");
		
		return false;
	}
	
	var password1		= document.forms["register-form"]["password"].value;
	var confirm_pass	= document.forms["register-form"]["confirm-password"].value;
	
	var passwordRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
	/*The string must contain at least 1 lowercase alphabetical character
	The string must contain at least 1 uppercase alphabetical character
	The string must contain at least 1 numeric character
	The string must contain at least one special character, but we are escaping reserved RegEx characters to avoid conflict
	The string must be eight characters or longer
	*/
	if (password1.length > 0)
	{
		if (!passwordRegex.test (password1))
		{
			
			alert ("Password must contain at-least one lowercase alphabetical character, one uppercase character, one special character and must have be at-least 8 characters");
			
			return false;
		}
	}
	else
	{
		alert ("Password field is mandatory");
		
		return false;
	}
	//
	if(confirm_pass.length <= 0)
	{
		alert ("Confirm Password field is mandatory");
		
		return false;
	}
	else
	{
		if (password1 != confirm_pass)
		{
				alert ("Passwords do not match");
			
				return false;
		}
	}
	
	
	
	
	var firstname	= document.forms["register-form"]["firstname"].value;
	
	if (firstname.length <= 0)
	{
		alert ("First name is mandatory");
	}
	
	var lastname	= document.forms["register-form"]["lastname"].value;
	
	if (lastname.length <= 0)
	{
		alert ("Last name is mandatory");
	}
	
	var email	= document.forms["register-form"]["email"].value;
	var email_regex	= /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	
	if (email.length > 0)
	{
		if (!email.match (email_regex))
		{
			alert ("Email is mandatory and must be valid");
			
			return false;
		}
	}
	else
	{
		alert ("Email is mandatory");
		
		return false;
	}
}
