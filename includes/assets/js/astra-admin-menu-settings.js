/**
 * Install Analytica Starter Sites
 *
 *
 * @since 1.2.4
 */

(function($){

	AstraThemeAdmin = {

		init: function()
		{
			this._bind();
		},


		/**
		 * Binds events for the Analytica Theme.
		 *
		 * @since 1.0.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( document ).on('click' , '.ast-sites-notinstalled', AstraThemeAdmin._installNow );
			$( document ).on('click' , '.ast-sites-inactive', AstraThemeAdmin._activatePlugin);
			$( document ).on('wp-plugin-install-success' , AstraThemeAdmin._activatePlugin);
			$( document ).on('wp-plugin-installing'      , AstraThemeAdmin._pluginInstalling);
			$( document ).on('wp-plugin-install-error'   , AstraThemeAdmin._installError);
		},

		/**
		 * Plugin Installation Error.
		 */
		_installError: function( event, response ) {

			var $card = jQuery( '.ast-sites-notinstalled' );

			$card
				.removeClass( 'button-primary' )
				.addClass( 'disabled' )
				.html( wp.updates.l10n.installFailedShort );
		},

		/**
		 * Installing Plugin
		 */
		_pluginInstalling: function(event, args) {
			event.preventDefault();

			var $card = jQuery( '.ast-sites-notinstalled' );

			$card.addClass('updating-message');

		},
		/**
		 * Activate Success
		 */
		_activatePlugin: function( event, response ) {

			event.preventDefault();

			var $message = $( '.ast-sites-notinstalled' );
			if ( 0 === $message.length ) {
				$message = $( '.ast-sites-inactive' );
			}

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass('updating-message')
				.html( analytica.btnActivating );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax({
					url: analytica.ajaxUrl,
					type: 'POST',
					data: {
						'action'            : 'analytica-sites-plugin-activate',
						'init'              : $init,
					},
				})
				.done(function (result) {

					if( result.success ) {
						var output = '<a href="'+ analytica.analyticaSitesLink +'" aria-label="'+ analytica.analyticaSitesLinkTitle +'">' + analytica.analyticaSitesLinkTitle +' </a>'
						$message.removeClass( 'ast-sites-inactive ast-sites-notinstalled button button-primary install-now activate-now updating-message' )
							.html( output );

					} else {

						$message.removeClass( 'updating-message' );

					}

				});

			}, 1200 );

		},

		/**
		 * Install Now
		 */
		_installNow: function(event)
		{
			event.preventDefault();

			var $button 	= jQuery( event.target ),
				$document   = jQuery(document);

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.ast-sites-notinstalled.updating-message' );

					$message
						.addClass('ast-sites-inactive')
						.removeClass( 'updating-message ast-sites-notinstalled' )
						.text( wp.updates.l10n.installNow );

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}

			wp.updates.installPlugin( {
				slug:    $button.data( 'slug' )
			} );
		},
	};

	/**
	 * Initialize AstraThemeAdmin
	 */
	$(function(){
		AstraThemeAdmin.init();
	});

})(jQuery);