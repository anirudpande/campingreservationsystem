$(document).ready (function () {
	getReservations (new Date ());
})

var getReservations = function (pTodayDate) {
	
	// Empty the table
	// Empty the table
	$('#myreservations-grid').find ('tbody').empty ();
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/get_myreservations.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {},
		success		: function (pResult) {
					try
					{
						var oJSON	= $.parseJSON (pResult);
						
						for (var x in oJSON)
						{
							$('#myreservations-grid').find ('tbody')
								.append ($('<tr>')
									.append ($('<td>')
										.append (oJSON [x].RESERVATION_ID)
									)
									.append ($('<td>')
										.append (oJSON [x].NAME)
									)
									.append ($('<td>')
										.append (oJSON [x].START_DATETIME)
									)
									.append ($('<td>')
										.append (oJSON [x].END_DATETIME)
									)
									.append ($('<td>')
										.append (oJSON [x].SLOTS_BOOKED)
									)
									.append ($('<td>')
										.append ($('<input>')
											.attr ('type', 'checkbox'))
										)
									);
						}
					}
					catch (pError)
					{
						console.log (pError);
						$(location).attr ('href', pResult);
					}
						
					var iCtr	= 1;
					var sBuilding	= '';
					var sRoomName	= '';
					var sFloor	= '';
					var sStartDate	= '';
					var sEndDate	= '';
					
					// sFlag values
					$('#myreservations-grid').each (function () {
						$(this).find('td').each (function() {
							
							if (iCtr == 1)
							{
								sRoomName	= ($(this) [0]. innerHTML);
							}
							else if (iCtr == 2)
							{
								sBuilding	= ($(this) [0]. innerHTML);
							}
							else if (iCtr == 3)
							{
								sFloor		= ($(this) [0]. innerHTML);
							}
							else if (iCtr == 4)
							{
								sStartDate	= new Date ($(this) [0]. innerHTML);
							}
							else if (iCtr == 5)
							{
								sEndDate	= new Date ($(this) [0]. innerHTML);
							}
							else if (iCtr == 6)
							{
								iCtr	= 0;
								
								var row		= $(this).parent ();
								var checkBox	= $(this) [0];
								
								if (pTodayDate > sStartDate)
								{
									checkBox.lastChild.disabled = true;
									row.attr ('class', 'danger');	
								}
							}
							
							iCtr = iCtr + 1;
						})
					})
				},
		error		: function (pError) {
					console.log (pError);
				  }
	})
}

$(document).on ('click', '#cancel-reservations', function () {
	
	var iCtr	= 1;
	var sBuilding	= '';
	var sRoomName	= '';
	var sFloor	= '';
	var sStartDate	= '';
	var sEndDate	= '';
	
	// sFlag values
	// 0 - Check for available slots of the room
	$('#myreservations-grid').each (function () {
		$(this).find('td').each (function() {
			
			if (iCtr == 1)
			{
				sRoomName	= ($(this) [0]. innerHTML);
			}
			else if (iCtr == 2)
			{
				sBuilding	= ($(this) [0]. innerHTML);
			}
			else if (iCtr == 3)
			{
				sFloor		= ($(this) [0]. innerHTML);
			}
			else if (iCtr == 4)
			{
				sStartDate	= ($(this) [0]. innerHTML);
			}
			else if (iCtr == 5)
			{
				
				sEndDate	= ($(this) [0]. innerHTML);
			}
			else if (iCtr == 6)
			{
				iCtr	= 0;
				
				var row		= $(this).parent ();
				var checkBox	= $(this) [0];
				
				if (checkBox.lastChild.checked == true)
				{
					$.ajax ({
						type		: 'POST',
						url		: 'http://localhost:9998/Pro/php/cancel_myreservations.php',
						cache		: 'false',
						async		: 'false',
						datatype	: 'html',
						data		: {
									sRoomName:sRoomName,
									sBuilding:sBuilding,
									sFloor:sFloor,
									sStartDateTime:sStartDate,
									sEndDateTime:sEndDate
								  },
						success		: function (pResult) {
									console.log (pResult);
								  },
						error		: function (pError) {
									console.log (pError);
								  }
					})
					
				}
			}
			
			iCtr = iCtr + 1;
		})
	})
	
	getReservations (new Date ());
})
