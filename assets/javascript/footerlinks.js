
function SetFooterLinks(jqueryPageId, footerobjects){
	var selector = jqueryPageId;// + " div:last";
	//console.log(selector);
	var links = $(selector).find("#footerlist");
	links.html("");
	var ul = document.createElement("ul");
	for (var i = 0; i < footerobjects.length; i ++){
		var obj = footerobjects[i];
		var li = document.createElement("li");
		var a = document.createElement("a");
		li.appendChild(a);
		ul.appendChild(li);
		a.setAttribute('href', obj.url);
		a.setAttribute('id', obj.name.toLowerCase() +"_footer_link");
		a.setAttribute('data-icon', obj.icon);
		if (obj.url.indexOf("map.php") == 0) {
			a.setAttribute('rel', 'external');
		}
		a.innerHTML = obj.name;
	}
	links.append(ul);
}