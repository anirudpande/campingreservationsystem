$(document).ready (function () {

})


var setRoomPortfolio = function (camp_name,street_name,city,state,image_path,maxslots,features,geography,recreation,facilities) {
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/set_room_portfolio.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'html',
		data		: {camp: camp_name,
				   street:street_name,
				   city: city,
				   state: state,
				   image_path:image_path,
				   maxslots: maxslots,
				   features: features,
				   geography:geography,
				   recreation:recreation,
				   facilities:facilities
				  },
		success		: function (pResult) {
					$(location).attr ('href', pResult);
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error");
					console.log (pError);
				  }
		})
}

$(document).on('click', '#add-room', function () {
	
	var image_path	= $('#room-image-form-filebutton').val ().split ('\\') [2];
	
	if (image_path)
	{
		image_path	= 'http://localhost:9998/Pro/images/' + image_path;
	}
	else
	{
		image_path	= '';
	}
	
	var camp_name	= $('#building-name-form-input').val ();
	var street_name		= $('#room-name-form-input').val ();
	var city		= $('#city-name-form-input').val ();
	var state		= $('#state-name-form-input').val ();
	var maxslots	= $('#min-occupancy-form-select').val ();
	var features		= $('#room-desc-form-textarea').val ();
	var geography		= $('#geography-form-textarea').val ();
	var recreation		= $('#recreation-form-textarea').val ();
	var facilities		= $('#facilities-form-textarea').val ();
	
	setRoomPortfolio (camp_name,street_name,city,state,image_path,maxslots,features,geography,recreation,facilities);
})

$(document).on('click', '#clear-form', function () {
	document.forms ['edit-form'].reset ();
})
