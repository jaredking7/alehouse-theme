( function( $ ) {
  "use strict";
  
	$( window ).load( function() {
		
		// Check to see if nivo has been included and run the slider if it exists
		if ( $().nivoSlider ) { 
			
			$( '#slider' ).nivoSlider( { 
				effect: alehouse_slider.effect,
				slices: parseInt( alehouse_slider.slices ),
				boxCols: parseInt( alehouse_slider.boxCols ),
				boxRows: parseInt( alehouse_slider.boxRows ),
				animSpeed: parseInt( alehouse_slider.animSpeed ),
				pauseTime: parseInt( alehouse_slider.pauseTime ),
				directionNav: true,
				controlNav: false,
				controlNavThumbs: false,
				pauseOnHover: true,
				manualAdvance: false,
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				randomStart: false,
			} );
			
		}
		
	} ); // window.load

	$( document).ready( function() { 
		
		// only use lightbox when it has been enqueued
		if( $().nivoLightbox ) {
			$( '.lightbox' ).nivoLightbox();
			$( '.gallery-item a' ).nivoLightbox();
		}
		
		// show the background image if it has been set
		if ( alehouse_background.image !== '' && $().backstretch ) {
			$.backstretch( alehouse_background.image );	
		}
		
		$( '#mobile-menu-button' ).click( function() {		
			$( '#main-menu' ).slideToggle( 'fast' );
		} );;
		
	} ); // document.ready
	
} )( jQuery );