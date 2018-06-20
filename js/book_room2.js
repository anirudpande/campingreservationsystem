$(document).ready (function () {
	$(function () {
		$('#datetimepicker').datetimepicker ({
			useCurrent: true,
			calendarWeeks: true,
			toolbarPlacement: 'top',
			format: 'YYYY-MM-DD',
			minDate: moment ().hours (0).minutes (0). seconds (0).milliseconds (0).toDate (),
			maxDate: moment ().add (30, 'd').hours (23).minutes (59). seconds (59).milliseconds (99).toDate (),
			defaultDate: moment ().hours (0).minutes (0). seconds (3).milliseconds (0).toDate ()
		});
		$('#datetimepicker1').datetimepicker ({
			useCurrent: true,
			calendarWeeks: true,
			toolbarPlacement: 'top',
			format: 'YYYY-MM-DD',
			minDate: $('#datetimepicker').data ('date'),
			maxDate: moment ().add (30, 'd').hours (23).minutes (59). seconds (59).milliseconds (99).toDate (),
			defaultDate: moment ().hours (0).minutes (0). seconds (3).milliseconds (0).toDate ()
		});
	});
	
	getRoomPortfolio ();
})

var getRoomPortfolio = function () {
	
	var room_image	= $('#room-image');
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/get_room_portfolio1.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {},
		success		: function (pResult) {
					console.log (pResult);
					var oJSON = $.parseJSON (pResult);
					for (var x in oJSON)
					{
						room_image.attr ('src', oJSON [x].IMAGE_PATH);
						room_image.attr ('title', oJSON [x].NAME);
						document.getElementById("features").innerHTML=oJSON [x].features;
						document.getElementById("geography").innerHTML=oJSON [x].GEOGRAPHY;
						document.getElementById("facilities").innerHTML=oJSON [x].FACILITIES;
						document.getElementById("recreation").innerHTML=oJSON [x].RECREATION;
						document.getElementById("price").innerHTML=oJSON [x].PRICE;
					}
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error 123");
					console.log (pError);}
		})
}

$(document).on('click', '#get-slots', function () {
	var checkinDate	= $('#datetimepicker').data ('date');
	var checkoutDate	= $('#datetimepicker1').data ('date');
	if(checkoutDate< checkinDate)
	{
		alert ("Check out date cannot be before check in date");
		$('#datetimepicker1').innerHTML='';
	}
	else
	{
		getAvailableSlots ();
	}
})

var getAvailableSlots = function () {
	var checkinDate	= $('#datetimepicker').data ('date');
	var checkoutDate	= $('#datetimepicker1').data ('date');
	var e = document.getElementById("slotspicker");
	var slotspicked = e.options[e.selectedIndex].value;
	console.log(checkinDate);
	console.log(checkoutDate);
	console.log(slotspicked);

	var todayDate	= new Date ();
	
	$.ajax ({
		type		: 'POST',
		url			: 'http://localhost:9998/Pro/php/check_room.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'html',
		data		: {
					sFlag:0,
					sStartDateTime:checkinDate+' '+'00:00:00',
					sEndDateTime:checkoutDate+' '+'00:00:00',
					slots:slotspicked
				   },
		success		: function (pResult) {
					console.log(pResult);
					if (pResult == 0)
					{
						document.getElementById("reserve-slots").disabled = false;
					}
					if (pResult == 1)
					{
						document.getElementById("reserve-slots").disabled = true;
					}
				},
		error		: function (pError) {
					alert ("PHP retrieval Error");
					console.log (pError);}
	})
}

var displaySuccessMsg = function () {
	
	$('#info-msg').css ('display', 'block');
}

var hideSuccessMsg = function () {
	
	$('#info-msg').css ('display', 'none');
}

$(document).on('click', '#reserve-slots', function () {
	
	
	var checkinDate	= $('#datetimepicker').data ('date');
	var checkoutDate	= $('#datetimepicker1').data ('date');
	var e = document.getElementById("slotspicker");
	var slotspicked = e.options[e.selectedIndex].value;
	
		
	$.ajax ({
		type		: 'POST',
		url			: 'http://localhost:9998/Pro/php/reserve_room.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'html',
		data		: {
					sStartDateTime:checkinDate+' '+'00:00:00',
					sEndDateTime:checkoutDate+' '+'00:00:00',
					slots:slotspicked
				  },
		success		: function (pResult) {
					if(pResult ==0)
					{
						
						window.location.href = "PaymentPage.html";
					}					
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error");
					console.log (pError);
				}
	})
})
