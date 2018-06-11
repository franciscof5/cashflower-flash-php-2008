window.addEvent('domready', function() {
	var status = {
		'true': 'open',
		'false': 'close'
	};
	
	//-vertical

	var myVerticalSlide = new Fx.Slide('vertical_slide');

	

	$('v_toggle').addEvent('click', function(e){
		e.stop();
		myVerticalSlide.toggle();
	});

	
	
	// When Vertical Slide ends its transition, we check for its status
	// note that complete will not affect 'hide' and 'show' methods
	myVerticalSlide.addEvent('complete', function() {
		$('vertical_status').set('html', status[myVerticalSlide.open]);
	});


	//--horizontal
	var myHorizontalSlide = new Fx.Slide('horizontal_slide', {mode: 'horizontal'});

	$('h_slidein').addEvent('click', function(e){
		e.stop();
		myHorizontalSlide.slideIn();
	});

	$('h_slideout').addEvent('click', function(e){
		e.stop();
		myHorizontalSlide.slideOut();
	});

	$('h_toggle').addEvent('click', function(e){
		e.stop();
		myHorizontalSlide.toggle();
	});

	$('h_hide').addEvent('click', function(e){
		e.stop();
		myHorizontalSlide.hide();
		$('horizontal_status').set('html', status[myHorizontalSlide.open]);
	});
	
	$('h_show').addEvent('click', function(e){
		e.stop();
		myHorizontalSlide.show();
		$('horizontal_status').set('html', status[myHorizontalSlide.open]);
	});
	
	// When Horizontal Slide ends its transition, we check for its status
	// note that complete will not affect 'hide' and 'show' methods
	myHorizontalSlide.addEvent('complete', function() {
		$('horizontal_status').set('html', status[myHorizontalSlide.open]);
	});
});