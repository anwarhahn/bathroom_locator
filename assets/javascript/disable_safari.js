function disable_safari() {
	return;
	$("a").click(function(evt) {
		evt.preventDefault();
		console.log(this);
		//alert("hello");
		window.location = $( this ).attr( "href" );
		return false;
	});
}
