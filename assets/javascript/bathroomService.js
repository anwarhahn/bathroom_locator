function BathroomService(markerManager)
{
	this.markerManager = markerManager;
}

BathroomService.prototype.textSearch = function(request)
{
	var markers = this.markerManager.markers;
	var location = request.location;
	var query = request.query; // want to tokenize query

	var visible = [];
	var invisible = [];

	for(var i = 0; i < markers.length; i++) {
		var marker = markers[i];
		var title = marker.title;
		var position = marker.position;
		if (title.toLowerCase().indexOf(query.toLowerCase()) != -1) {
			visible.push(marker);
		}
		else {
			invisible.push(marker);
		}
	}
	this.markerManager.markerVisibility(true, visible);
	this.markerManager.markerVisibility(false, invisible);
}

