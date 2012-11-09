function SetFooterLinks(footerobjects){
	var links = document.getElementById("footerlist");
	var list = "<ul>";
	for (var i = 0; i < footerobjects.length; i ++){
		var obj = footerobjects[i];
		list += "<li><a href='" + (obj['url']) +"' id='"+ (obj['url']) +"' data-icon='"+ (obj['icon']) +"'>"+ (obj['name']) +"</a></li>";
	}
	links.innerHTML=list + "</ul>";	
	
}