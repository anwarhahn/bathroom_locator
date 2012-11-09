function MarkerManager(map)
{
	this.map = map;
	this.markers = [];
	this.currentInfoWindow = null;
}

MarkerManager.prototype.addMarkersFromJSON = function(json)
{
	for (var arrayPos in json) {
		var elem = json[arrayPos];
		var latLng = this.makeLatLng(elem.latitude, elem.longitude);
		this.addMarker(latLng, elem.name);
	}
}

MarkerManager.prototype.makeLatLng = function(latitude, longitude)
{
	return new google.maps.LatLng(latitude, longitude);
}

MarkerManager.prototype.addMarker = function(latLng, name)
{
	var obj = this;
	var marker = new google.maps.Marker({
						map: obj.map,
						title: name,
						position: latLng,
						visible: true,
						clickable: true
						});
	var popup = function() {
		var button = document.createElement("button");
		button.innerHTML = ">";
		button.onclick = function(evt) {
			var query = ["name=" + escape(name), "origin=" + escape("map")];

			window.location = "specificBathroom.php?" + query.toString().replace(',', '&');
		}
		var p = document.createElement("p");
		p.innerHTML = name + " ";
		p.appendChild(button);
		var infoWindowOptions = {
			content: p
		}
		var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
		obj.openInfoWindow(infoWindow, marker);
		obj.addListener(infoWindow, 'closeclick', function() {obj.openInfoWindow(null, null);});
	}

	this.addListener(marker, 'click', popup);	
	this.markers.push(marker);
}

MarkerManager.prototype.openInfoWindow = function(infoWindow, marker)
{
	if (this.currentInfoWindow) {
		this.currentInfoWindow.close();
		this.currentInfoWindow = null;
	}
	if (!infoWindow) {
		this.currentInfoWindow = null;
		return;
	}
	var obj = this;
	infoWindow.open(obj.map, marker);
	this.currentInfoWindow = infoWindow;
}

MarkerManager.prototype.addListener = function(instance, eventName, handler)
{
	google.maps.event.addListener(instance, eventName, handler);
}


MarkerManager.prototype.computeDistanceBetween = function(latLng1, latLng2)
{
	return google.maps.geometry.spherical.computeDistanceBetween(latLng1, latLng2);
}

MarkerManager.prototype.distanceBetween = function(marker, latLng)
{
	return computeDistanceBetween(marker.position, latLng);
}

MarkerManager.prototype.filterWithinDistance = function(distance, latLng)
{
	var valid = [];
	for(var i = 0; i < this.markers.length; i++) {
		var marker = this.markers[i];
		var dist = this.distanceBetween(marker, latLng);
		if (dist <= distance) {
			valid.push(marker);
		}
	}
}

MarkerManager.prototype.setMarkerVisibility = function(marker, visibility) {
    if (visibility) {
        marker.setMap(this.map);
    }
    else {
        marker.setMap(null);
    }
}


MarkerManager.prototype.markerVisibility = function(visibility, markers)
{
	var markers = markers || this.markers;

	for(var i = 0; i < markers.length; i++) {
		var marker = markers[i];
		this.setMarkerVisibility(marker, visibility);
	}	
}
