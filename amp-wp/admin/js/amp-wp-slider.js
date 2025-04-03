(function( $ ) {
    'use strict';
	
	$(function () {
		
		$('.customize-control-range').each( function() {
			var rangeInput = $(this).find( 'input[type="range"]' ),
				textInput = $(this).find( 'input[type="text"]' );
				
			// If the range input value changes,
			// copy the value to the text input
			// and then save.
			rangeInput.on( 'mousemove change', function() {
				textInput.attr( 'value', rangeInput.val() );
				wp.customize( 'amp-wp-header-height', function ( control ) {
					control.set( rangeInput.val() );
				});
			});
			
			// If the text input value changes,
			// copy the value to the range input
			// and then save.
			textInput.on( 'input paste change', function() {
				rangeInput.attr( 'value', textInput.val() );
				wp.customize( 'amp-wp-header-height', function ( control ) {
					control.set( textInput.val() );
				});
			} );
			
			// If the reset button is clicked,
			// set slider and text input values to default
			// and hen save.
			$(this).find( '.slider-reset' ).on( 'click', function() {
				textInput.attr( 'value', rangeInput.prop('min') );
				rangeInput.attr( 'value', rangeInput.prop('min') );
				wp.customize( 'amp-wp-header-height', function ( control ) {
					control.set( textInput.val() );
				});
			});
		});
		
		var initKirkiControl = function() {
			
			var control      = this,
				changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
				rangeInput   = control.container.find( 'input[type="range"]' ),
				textInput    = control.container.find( 'input[type="text"]' ),
				value        = control.setting._value;

			// Set the initial value in the text input.
			textInput.attr( 'value', value );

			// If the range input value changes,
			// copy the value to the text input
			// and then save.
			rangeInput.on( changeAction, function() {
				textInput.attr( 'value', rangeInput.val() );
				control.setting.set( rangeInput.val() );
			} );

			// If the text input value changes,
			// copy the value to the range input
			// and then save.
			textInput.on( 'input paste change', function() {
				rangeInput.attr( 'value', textInput.val() );
				control.setting.set( textInput.val() );
			} );

			// If the reset button is clicked,
			// set slider and text input values to default
			// and hen save.
			control.container.find( '.slider-reset' ).on( 'click', function() {
				textInput.attr( 'value', control.params['default'] );
				rangeInput.attr( 'value', control.params['default'] );
				control.setting.set( textInput.val() );
			} );
		}
		
		//initKirkiControl();
		
		/**
		 * Slider Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
		$('.slider-custom-control').each( function(){
			var sliderValue = $(this).find('.customize-control-slider-value').val();
			var newSlider = $(this).find('.slider');
			var sliderMinValue = parseFloat(newSlider.attr('slider-min-value'));
			var sliderMaxValue = parseFloat(newSlider.attr('slider-max-value'));
			var sliderStepValue = parseFloat(newSlider.attr('slider-step-value'));
			
			newSlider.slider({
				value: sliderValue,
				min: sliderMinValue,
				max: sliderMaxValue,
				step: sliderStepValue,
				change: function(e,ui){
					// Important! When slider stops moving make sure to trigger change event so Customizer knows it has to save the field
					$(this).parent().find('.customize-control-slider-value').trigger('change');
				}
			});
		});
		
	});
})( jQuery );