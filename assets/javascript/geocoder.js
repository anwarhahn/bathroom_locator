var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);

var geocoderRequest = {
	address: bathroomAddress,
	location: stanfordLatLng
}


var callback = function(geocoderResultArray, geocoderStatus)
{
	if (geocoderStatus == google.maps.GeocoderStatus.OK) {
		for(var i = 0; i < geocoderResultArray.length; i++) {
			
		}
	}
}

var geocoder = google.maps.Geocoder();
geocoder.geocode(geocoderRequest, callback);