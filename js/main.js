var ps=1;
var array1 = [1,2];

$(document).ready (function () {
	
	getRooms ();
})

$(document).on('click', '#search-button', function () {
	searchCamps();
})

var searchCamps = function()
{
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
}
var getRooms = function (pAll, pState, pCity, pCampName) {
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/main.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {all:pAll, state:pState, city:pCity, name:pCampName},
		success		: function (pResult) {
					
					console.log (pResult);
					try
					{
						var oJSON	= $.parseJSON (pResult);
						
						$('#search-grid').find ('tbody').empty ();
						$('#search-grid').find('th').eq(2).hide();
						$('#search-grid').find('th').eq(3).hide();
						$('#search-grid').find('th').eq(4).hide();
						$('#search-grid').find('th').eq(5).hide();
						$('#search-grid').find('th').eq(6).hide();
						var counter=0;
						for (var x in oJSON)
						{
							counter++;
							if(array1.indexOf(counter)!=-1)
							{
							$('#search-grid').find ('tbody')
								.append ($('<tr>')
									.append ($('<td>')
										.append ($('<img>')
										  .attr ('src', oJSON [x].IMAGE_PATH)
										  .attr ('height', '300')
										  .attr ('width', '350')
										)
									)
									.append ($('<td>')
										.append (oJSON [x].NAME)
										.append(" <br>")
										.append(" <br>")
										.append (oJSON [x].GEOGRAPHY)
										.append(" <br>")
										.append (oJSON [x].FEATURES)
										.append(" <br>")
										.append (oJSON [x].RECREATION)
										.append(" <br>")
									)
									.append ($('<td>')
										.append (oJSON [x].NAME)
										.hide()
									)
									.append ($('<td>')
										.append (oJSON [x].NAME)
										.hide()
									)
									.append ($('<td>')
										.append (oJSON [x].states)
										.hide()
									)
									.append ($('<td>')
										.append (oJSON [x].city)
										.hide()
									)
									.append ($('<td>')
										.append (oJSON [x].RECREATION)
										.hide()
									)
									.append ($('<td>')
										.append ($('<input>')
										  .attr ('type', 'button')
										  .attr ('id', 'book-button')
										  .attr ('class', 'btn btn-primary')
										  .attr ('value', 'Book')
										)
									)
								);
							}
						}
					}
					catch (pError)
					{
						$(location).attr ('href', pResult)
					}
				},
		error		: function (pError) {alert ("PHP retrieval Error 1111");}
	})
}
$(document).on('click', '#book-button', function () {
	
	var row	= ($(this).parent ().parent ());
	
	console.log (row [0].cells [0].innerHTML);
	
	var camp_name	= row [0].cells [2].innerHTML;
	var state		= row [0].cells [4].innerHTML;
	var city		= row [0].cells [5].innerHTML;
	
	$.ajax ({
		type		: 'POST',
		url			: 'http://localhost:9998/Pro/php/book_room.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'html',
		data		: {state: state, city: city, camp_name: camp_name},
		success		: function (pResult) {
						$(location).attr ('href', pResult)
					},
		error		: function (pError) {alert ("PHP retrieval Error 2222");}
	})
})


$(document).on('click', '#1', function () {
	ps=1;
	array1=[1,2];
	document.getElementById("1").classList.add('active');
	document.getElementById("2").classList.remove('active');
	document.getElementById("3").classList.remove('active');
	document.getElementById("4").classList.remove('active');
	document.getElementById("5").classList.remove('active');
	document.getElementById("6").classList.remove('active');
	searchCamps();
})
$(document).on('click', '#2', function () {
	ps=2;
	array1=[3,4];
	document.getElementById("2").classList.add('active');
	document.getElementById("1").classList.remove('active');
	document.getElementById("6").classList.remove('active');
	document.getElementById("3").classList.remove('active');
	document.getElementById("4").classList.remove('active');
	document.getElementById("5").classList.remove('active');
	searchCamps();
})
$(document).on('click', '#3', function () {
	ps=3;
	array1=[5,6];
	document.getElementById("3").classList.add('active');
	document.getElementById("1").classList.remove('active');
	document.getElementById("2").classList.remove('active');
	document.getElementById("4").classList.remove('active');
	document.getElementById("5").classList.remove('active');
	document.getElementById("6").classList.remove('active');
	searchCamps();
})
$(document).on('click', '#4', function () {
	ps=4;
	array1=[7,8];
	document.getElementById("4").classList.add('active');
	document.getElementById("2").classList.remove('active');
	document.getElementById("3").classList.remove('active');
	document.getElementById("1").classList.remove('active');
	document.getElementById("5").classList.remove('active');
	document.getElementById("6").classList.remove('active');
	searchCamps();
})
$(document).on('click', '#5', function () {
	ps=5;
	array1=[9,10];
	document.getElementById("5").classList.add('active');
	document.getElementById("2").classList.remove('active');
	document.getElementById("3").classList.remove('active');
	document.getElementById("4").classList.remove('active');
	document.getElementById("1").classList.remove('active');
	document.getElementById("6").classList.remove('active');
	searchCamps();
})
$(document).on('click', '#6', function () {
	ps=6;
	array1=[11,12];
	document.getElementById("6").classList.add('active');
	document.getElementById("2").classList.remove('active');
	document.getElementById("3").classList.remove('active');
	document.getElementById("4").classList.remove('active');
	document.getElementById("5").classList.remove('active');
	document.getElementById("1").classList.remove('active');
	searchCamps();
})