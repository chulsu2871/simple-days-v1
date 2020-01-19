jQuery(window).on("load", function() {
  	jQuery('html').addClass('colorpicker-ready');
});

	wp.customize.controlConstructor['color_alpha'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';

			var control = this,
				value,
				thisInput,
				inputDefault,
				changeAction;

			this.container.find('.color-picker' ).wpColorPicker({


			    change: function (event, ui) {
			        var element = event.target;
			        var color = ui.color.toString();

			        if ( jQuery('html').hasClass('colorpicker-ready') ) {
						control.setting.set( color );
			        }
			    },


			    clear: function (event) {
			        var element = jQuery(event.target).closest('.wp-picker-input-wrap').find('.wp-color-picker')[0];
			        var color = '';

			        if (element) {
			        	control.setting.set( color );
			        }
			    }
			});
		}
	});
