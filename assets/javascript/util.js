function get_params()
{
	var search = window.location.search;
	if (search.length == 0) return {};

	search = search.replace('?', '');
	var hash = {};
	var substrings = search.split("&");
	for(var i = 0; i < substrings.length; i++) {
		var keyAndValue = substrings[i].split("=");
		hash[keyAndValue[0]] = keyAndValue[1];
	}
	return hash;
}
