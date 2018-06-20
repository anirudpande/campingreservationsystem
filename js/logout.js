$(document).on('click', '#logout', function () {
	
	$.ajax ({
			type		: 'POST',
			url		: 'http://localhost:9998/Pro/php/logout.php',
			cache		: 'false',
			async		: 'false',
			datatype	: 'html',
			data		: {},
			success		: function (pResult) {
						console.log (pResult);
					  },
			error		: function (pError) {}
		})
})
