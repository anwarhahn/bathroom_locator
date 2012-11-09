function disable_safari() {
	$("a").click(function(evt) {
		evt.preventDefault();
		console.log(this);
		//alert("hello");
		window.location = $( this ).attr( "href" );
		return false;
	});
}
