$("a").click(function(evt) {
	evt.preventDefault();
	window.location = this.attr("href");
	return false;
});