$(document).ready (function () {
	
	getRooms ('','','','');
})

$(document).on('click', '#search-button', function () {
	
	var iValue	= $('#search-filter').val ();
	
	if (iValue == 0)
	{
		// All Search Criteria
		getRooms ($('#search-keyword').val (), '', '', '');
	}
	else if (iValue == 1)
	{
		// Building Search criteria
		getRooms ('', $('#search-keyword').val (), '', '');
	}
	else if (iValue == 2)
	{
		// Floor Search criteria
		getRooms ('', '', $('#search-keyword').val (), '');
	}
	else if (iValue == 3)
	{
		// Room Name Search criteria
		getRooms ('', '', '', $('#search-keyword').val ());
	}
	
})

var getRooms = function (pAll, pBuilding, pFloor, pRoomName) {
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/main.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {all:pAll, building:pBuilding, floor:pFloor, name:pRoomName},
		success		: function (pResult) {
					
					console.log (pResult);
					try
					{
						var oJSON	= $.parseJSON (pResult);
						
						$('#search-grid').find ('tbody').empty ();
						
						for (var x in oJSON)
						{
							$('#search-grid').find ('tbody')
								.append ($('<tr>')
									.append ($('<td>')
										.append (oJSON [x].NAME)
									)
									.append ($('<td>')
										.append (oJSON [x].states)
									)
									.append ($('<td>')
										.append (oJSON [x].city)
									)
									.append ($('<td>')
										.append (oJSON [x].RECREATION)
									)
									.append ($('<td>')
										.append ($('<input>')
										  .attr ('type', 'button')
										  .attr ('id', 'editroom-button')
										  .attr ('class', 'btn btn-primary')
										  .attr ('value', 'Edit')
										)
									)
								);
						}
					}
					catch (pError)
					{
						$(location).attr ('href', pResult)
					}
				},
		error		: function (pError) {alert ("PHP retrieval Error");}
	})
}

$(document).on('click', '#add-room', function () {
		
		$(location).attr ('href', 'http://localhost:9998/Pro/add_room_info.html');
})

$(document).on('click', '#editroom-button', function () {
	
	var row	= ($(this).parent ().parent ());
	
	var name		= row [0].cells [0].innerHTML;
	var states		= row [0].cells [1].innerHTML;
	var city		= row [0].cells [2].innerHTML;
	var recreation	= row [0].cells [3].innerHTML;
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/edit_room.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'html',
		data		: {name:name,states: states, city:city, recreation: recreation},
		success		: function (pResult) {
						console.log (pResult);
						$(location).attr ('href', pResult);
					},
		error		: function (pError) {alert ("PHP retrieval Error");}
	})
})
