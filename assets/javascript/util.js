function get_params(searchString)
{
	if (searchString) {
		var from = 0;
		var to = searchString.length;
		var index = searchString.indexOf('?');
		if (index != -1) from = index;
		var search = searchString.substring(from, to);
	}
	else {
		var search = window.location.search;
	}
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


function old_params()
{
	var params = get_params();
	if (params["origin"]) delete params.origin;
	return params;
}

function stringify_params(params)
{
	var list = [];
	for(key in params) {
		list.push(key + "=" + params[key]);
	}
	return list.join("&");
}

function query_string(oldParamsHash, newParamsHash)
{
	var query = "?";
	for(key in newParamsHash) {
		oldParamsHash[key] = newParamsHash[key];
	}
	query += stringify_params(oldParamsHash);
	return query;
}


function filter_from_params(parameters)
{
	var params = parameters || get_params();
	var form = params.form;
	if(!form) form = escape("{}");
	var json = unescape(form);
	return JSON.parse(json);
}

function matches_filter_requirements(filterHash, bathroom)
{
	for(var requirement in filterHash) {
		//console.log(bathroom[requirement] +" "+ typeof(bathroom[requirement]));
		//console.log(filterHash[requirement] +" "+ typeof(filterHash[requirement]))
		if (bathroom[requirement] != filterHash[requirement])
			return false;
	}
	return true;
}

function human_readable_address(bathroom)
{
	var address = bathroom.address.split(",");
	//console.log(address);
	var len = address.length;
	address[len-2] = address[len-2] + ", " + address[len-1];
	address.splice(len-1,1);
	address = address.join("<br />");
	return address;
}

function capitalize(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function bathroom_amenities(bathroom)
{
	var amenities_obj = {};
	var amenities = ["male", "female", "babychanging", "handicap"];
	for(var i = 0; i < amenities.length; i++) {
		var property = amenities[i];
		var value = bathroom[property];
		if (value != null) {
			amenities_obj[capitalize(property)] = value;
		}
	}
	return amenities_obj;
}