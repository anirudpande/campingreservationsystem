$(document).ready (function () {
	
	getRoomPortfolio ();
})

var oJSON	= '';

var getRoomPortfolio = function () {
	
	var room_image		= $('#room-image');
	var camp_name	= $('#building-name-form-input');
	var street_name		= $('#room-name-form-input');
	var city		= $('#city-name-form-input');
	var state		= $('#state-name-form-input');
	var maxslots	= $('#min-occupancy-form-select');
	var features		= $('#room-desc-form-textarea');
	var geography		= $('#geography-form-textarea');
	var recreation		= $('#recreation-form-textarea');
	var facilities		= $('#facilities-form-textarea');
	var price		= $('#price-form-input');
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/get_room_portfolio.php',
		cache		: 'false',
		async		: 'false',
		datatype	: 'JSON',
		data		: {},
		success		: function (pResult) {
					//alert (pResult);
					oJSON = $.parseJSON (pResult);
					
					for (var x in oJSON)
					{
						room_image.attr ('src', oJSON [x].IMAGE_PATH);
						room_image.attr ('title', oJSON [x].NAME);
						
						camp_name.val (oJSON [x].NAME);
						street_name.val (oJSON [x].STREET);
						city.val (oJSON [x].CITY);
						state.val (oJSON [x].STATES);
						maxslots.val (oJSON [x].MAX_SLOTS);
						features.val (oJSON [x].FEATURES);
						geography.val (oJSON [x].GEOGRAPHY);
						recreation.val (oJSON [x].RECREATION);
						facilities.val (oJSON [x].FACILITIES);
						price.val (oJSON [x].PRICE);
					}
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error");
					console.log (pError);}
		})
}

$(document).on('click', '#update-room', function () {
	
	var image_path	= $('#room-image-form-filebutton').val ().split ('\\') [2];
	
	if (image_path)
	{
		image_path	= 'http://localhost:9998/Pro/images/' + image_path;
	}
	else
	{
		for (var x in oJSON)
		{
			image_path	= oJSON [x].IMAGE_PATH;
		}
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
	var price		= $('#price-form-input').val();
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/update_room.php',
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
				   facilities:facilities,
				   price:price,
				   flag:'update'
				  },
		success		: function (pResult) {
					console.log(pResult);
					$(location).attr ('href', pResult)
				  },
		error		: function (pError) {
					console.log(pError);
					alert ("PHP retrieval Error111");
				  }
	      })
})

$(document).on('click', '#delete-room', function () {
	
	var camp_name	= $('#building-name-form-input').val ();
	var street_name		= $('#room-name-form-input').val ();
	var city		= $('#city-name-form-input').val ();
	var state		= $('#state-name-form-input').val ();
	var maxslots	= $('#min-occupancy-form-select').val ();
	var features		= $('#room-desc-form-textarea').val ();
	var geography		= $('#geography-form-textarea').val ();
	var recreation		= $('#recreation-form-textarea').val ();
	var facilities		= $('#facilities-form-textarea').val ();
	var image_path	= $('#room-image-form-filebutton').val ();
	var price		= $('#price-form-input').val();
	
	$.ajax ({
		type		: 'POST',
		url		: 'http://localhost:9998/Pro/php/update_room.php',
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
				   facilities:facilities,
				   price:price,
				   flag:'delete'
				  },
		success		: function (pResult) {
					console.log (pResult);
					$(location).attr ('href', pResult)
				  },
		error		: function (pError) {
					alert ("PHP retrieval Error");
					console.log (pError);
				  }
	      })
})
