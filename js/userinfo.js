$(document).ready (function () {
	
	getUserInfo ();
})

var getUserInfo = function () {
	
	var userinfo	= $('#user-info');
	var editrooms	= $('#edit-rooms');
	var userID	= '';
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/get_userinfo.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {},
		success		: function (pResult) {
					var oJSON	= $.parseJSON (pResult);
					
					for (var x in oJSON)
					{
						userID	= oJSON [x].USERID;
					}
					
					if (userID != 'admin')
					{
						editrooms.hide ();
						userinfo.text ('Welcome. ' + oJSON [x].LNAME + ', ' + oJSON [x].FNAME);
					}
					else
					{
						userinfo.text ('Welcome. ' + oJSON [x].LNAME + ', ' + oJSON [x].FNAME + ' (Administrator)');
					}
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error 33333");
					console.log (pError);
				  }
		})
}
