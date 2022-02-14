function runExample3() {
    var latlngs = $('#latlng_hidden').val().split(',');
    $("#custom-places").mapsed({
		showOnLoad:
		[
			// Random made up CUSTOM place
			{
				// flag that this place should have the tooltip shown when the map is first loaded
				autoShow: true,
				lat: latlngs[0],
				lng: latlngs[1],
				name: "SmartEDU",
				street: "Over the rainbow, Up high way",
				userData: 99
			}

		]

	});
}


$(document).ready(function() {
	runExample3();
});


