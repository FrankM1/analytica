jQuery( document ).ready( function( $ ) {

    $( '.customize-control.has-switchers' ).each( function( index ) {
		var $control 		= $( this ),
            $devices 	= $control.find( '.responsive-switchers' );
        if ( $devices.length >= 1 ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
            $control.parent().find( '#' + $control.attr( 'id' ) + '_mobile' ).removeClass( 'active' );
            $control.parent().find( '#' + $control.attr( 'id' ) + '_tablet' ).removeClass( 'active' );
        }
    });

	// Responsive switchers
	$( '.customize-control .responsive-switchers button' ).on( 'click', function( event ) {

		// Set up variables
		var $this 		= $( this ),
			$devices 	= $( '.responsive-switchers' ),
			$device 	= $( event.currentTarget ).data( 'device' ),
			$control 	= $( '.customize-control.has-switchers' ),
			$body 		= $( '.wp-full-overlay' ),
			$footer_devices = $( '.wp-full-overlay-footer .devices' );

		// Button class
		$devices.find( 'button' ).removeClass( 'active' );
		$devices.find( 'button.preview-' + $device ).addClass( 'active' );

		// Control class
        $control.removeClass( 'active' );

        if ( $device === 'desktop' ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
        } else {
            $control.parent().find( '#' + $control.attr( 'id' ) + '_' + $device ).addClass( 'active' );
        }

		$control.removeClass( 'control-device-desktop control-device-tablet control-device-mobile' ).addClass( 'control-device-' + $device );

		// Wrapper class
		$body.removeClass( 'preview-desktop preview-tablet preview-mobile' ).addClass( 'preview-' + $device );

		// Panel footer buttons
		$footer_devices.find( 'button' ).removeClass( 'active' ).attr( 'aria-pressed', false );
		$footer_devices.find( 'button.preview-' + $device ).addClass( 'active' ).attr( 'aria-pressed', true );

		// Open switchers
		if ( $this.hasClass( 'preview-desktop' ) ) {
			$control.toggleClass( 'responsive-switchers-open' );
		}

	});

	// If panel footer buttons clicked
	$( '.wp-full-overlay-footer .devices button' ).on( 'click', function( event ) {

		// Set up variables
		var $this 		= $( this ),
			$devices 	= $( '.customize-control.has-switchers .responsive-switchers' ),
			$device 	= $( event.currentTarget ).data( 'device' ),
			$control 	= $( '.customize-control.has-switchers' );

		// Button class
		$devices.find( 'button' ).removeClass( 'active' );
		$devices.find( 'button.preview-' + $device ).addClass( 'active' );

        // Control class
        $control.removeClass( 'active' );

        if ( $device === 'desktop' ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
        } else {
            $control.parent().find( '#' + $control.attr( 'id' ) + '_' + $device ).addClass( 'active' );
        }

		$control.removeClass( 'control-device-desktop control-device-tablet control-device-mobile' ).addClass( 'control-device-' + $device );

		// Open switchers
		if ( ! $this.hasClass( 'preview-desktop' ) ) {
			$control.addClass( 'responsive-switchers-open' );
		} else {
			$control.removeClass( 'responsive-switchers-open' );
		}

	});

});


wp.customize.controlConstructor['dimensions-responsive'] = wp.customize.Control.extend({

	ready: function() {
        'use strict';

        var control = this;

        // Init the control.
		if ( ! _.isUndefined( window.kirkiControlLoader ) && _.isFunction( kirkiControlLoader ) ) {
			kirkiControlLoader( control );
		} else {
			control.initKirkiControl();
        }
    },

    initKirkiControl: function() {

        var control = this,
            subControls = control.params.choices,
			value       = {},
			i;

		for ( i = 0; i < subControls.length; i++ ) {
            value[ subControls[ i ] ] = control.setting._value[ subControls[ i ] ];
			control.updateDimensionsValue( subControls[ i ], value );
		}
    },

    /**
	 * Updates the value.
	 */
	updateDimensionsValue: function( context, value ) {
        var control = this;

		control.container.on( 'change keyup paste', 'input.dimension-' + context, function() {
			value[ context ] = jQuery( this ).val();

			// Save the value
			control.saveValue( value );
		});
    },

    /**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		var control  = this,
			newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
	}

});

jQuery( document ).ready( function( $ ) {

	// Linked button
	$( '.analytica-linked' ).on( 'click', function() {

		// Set up variables
		var $this = $( this );

		// Remove linked class
		$this.parent().parent( '.dimension-wrap' ).prevAll().slice( 0, 4 ).find( 'input' ).removeClass( 'linked' ).attr( 'data-element', '' );

		// Remove class
		$this.parent( '.link-dimensions' ).removeClass( 'unlinked' );

	});

	// Unlinked button
	$( '.analytica-unlinked' ).on( 'click', function() {

		// Set up variables
		var $this 		= $( this ),
			$element 	= $this.data( 'element' );

		// Add linked class
		$this.parent().parent( '.dimension-wrap' ).prevAll().slice( 0, 4 ).find( 'input' ).addClass( 'linked' ).attr( 'data-element', $element );

		// Add class
		$this.parent( '.link-dimensions' ).addClass( 'unlinked' );

	});

	// Values linked inputs
	$( '.dimension-wrap' ).on( 'input', '.linked', function() {

		var $data 	= $( this ).attr( 'data-element' ),
			$val 	= $( this ).val();

		$( '.linked[ data-element="' + $data + '" ]' ).each( function( key, value ) {
			$( this ).val( $val ).change();
		});

	});

});

wp.customize.controlConstructor['analytica-icon'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this;

		// Change the value
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
/* global wp, JSON */
/* eslint consistent-this: [ "error", "control" ] */
/* eslint complexity: ["error", 8] */

(function(api, $) {
	'use strict'

	/**
	 * An image gallery control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.ImageGalleryControl = api.Control.extend({
		initialize: function(id, options) {
			var control = this,
				args

			args = options || {}

			if(!args.params.file_type) {
				args.params.file_type = 'image'
			}

			if(!args.params.type) {
				args.params.type = 'image_gallery'
			}
			if(!args.params.content) {
				args.params.content = $('<li></li>')
				args.params.content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'))
				args.params.content.attr('class', 'customize-control customize-control-' + args.params.type)
			}

			if(!args.params.attachments) {
				args.params.attachments = []
			}

			api.Control.prototype.initialize.call(control, id, args)
		},

		/**
		 * When the control's DOM structure is ready,
		 * set up internal event bindings.
		 */
		ready: function() {
			var control = this
			// Shortcut so that we don't have to use _.bind every time we add a callback.
			_.bindAll(control, 'openFrame', 'select')

			/**
			 * Set gallery data and render content.
			 */
			function setGalleryDataAndRenderContent() {
				var value = control.setting.get()
				control.setAttachmentsData(value).done(function() {
					control.renderContent()
					control.setupSortable()
				})
			}

			// Ensure attachment data is initially set.
			setGalleryDataAndRenderContent()

			// Update the attachment data and re-render the control when the setting changes.
			control.setting.bind(setGalleryDataAndRenderContent)

			// Bind events.
			control.container.on('click keydown', '.upload-button', control.openFrame)
		},

		/**
		 * Fetch attachment data for rendering in control content.
		 *
		 * @param {Array} value Setting value, array of attachment ids.
		 * @returns {*}
		 */
		setAttachmentsData: function(value) {
			var control = this,
				promises = []

			control.params.attachments = []

			_.each(value, function(id, index) {
				var hasAttachmentData = new $.Deferred()
				wp.media.attachment(id).fetch().done(function() {
					control.params.attachments[index] = this.attributes
					hasAttachmentData.resolve()
				})
				promises.push(hasAttachmentData)
			})

			return $.when.apply(undefined, promises).promise()
		},

		/**
		 * Open the media modal.
		 */
		openFrame: function(event) {
			event.preventDefault()

			if(!this.frame) {
				this.initFrame()
			}

			this.frame.open()
		},

		/**
		 * Initiate the media modal select frame.
		 * Save it for using later in case needed.
		 */
		initFrame: function() {
			var control = this,
				preSelectImages
			this.frame = wp.media({

				button: {
					text: control.params.button_labels.frame_button
				},
				states: [
					new wp.media.controller.Library({
						title: control.params.button_labels.frame_title,
						library: wp.media.query({ type: control.params.file_type }),
						multiple: 'add'
					})
				]
			})

			/**
			 * Pre-select images according to saved settings.
			 */
			preSelectImages = function() {
				var selection, ids, attachment, library

				library = control.frame.state().get('library')
				selection = control.frame.state().get('selection')

				ids = control.setting.get()

				// Sort the selected images to top when opening media modal.
				library.comparator = function(a, b) {
					var hasA = this.mirroring.get(a.cid) === true,
						hasB = this.mirroring.get(b.cid) === true

					if(!hasA && hasB) {
						return -1
					} else if(hasA && !hasB) {
						return 1
					} else {
						return 0
					}
				}

				_.each(ids, function(id) {
					attachment = wp.media.attachment(id)
					selection.add(attachment ? [attachment] : [])
					library.add(attachment ? [attachment] : [])
				})
			}
			control.frame.on('open', preSelectImages)
			control.frame.on('select', control.select)
		},

		/**
		 * Callback for selecting attachments.
		 */
		select: function() {
			var control = this,
				attachments, attachmentIds

			attachments = control.frame.state().get('selection').toJSON()
			control.params.attachments = attachments

			attachmentIds = control.getAttachmentIds(attachments)
			control.setSettingValues(attachmentIds)
		},

		/**
		 * Get array of attachment id-s from attachment objects.
		 *
		 * @param {Array} attachments Attachments.
		 * @returns {Array}
		 */
		getAttachmentIds: function(attachments) {
			var ids = [],
				i
			for(i in attachments) {
				ids.push(attachments[i].id)
			}
			return ids
		},

		/**
		 * Set setting values.
		 *
		 * @param {Array} values Array of ids.
		 */
		setSettingValues: function(values) {
			var control = this
			control.setting.set(values)
		},

		/**
		 * Setup sortable.
		 *
		 * @returns {void}
		 */
		setupSortable: function() {
			var control = this,

				list = $('.image-gallery-attachments')

				list.sortable({
					items: '.image-gallery-thumbnail-wrapper',
					tolerance: 'pointer',
					stop: function() {
						var selectedValues = []
						list.find('.image-gallery-thumbnail-wrapper').each(function() {
							var id
							id = parseInt($(this).data('postId'), 10)
							selectedValues.push(id)
						})
						control.setSettingValues(selectedValues)
					}
				})
		}

	})

	api.controlConstructor['image_gallery'] = api.ImageGalleryControl
})(wp.customize, jQuery)
