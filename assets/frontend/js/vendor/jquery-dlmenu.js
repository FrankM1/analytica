/**
 * Modified for Radium Megamenu
 * by Franklin M Gitonga
 * http://radiumthemes.com
 *
 * jquery.dlmenu.js v1.0.1
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
( function( $, window, undefined ) {
    'use strict';

    // global
    var $body = $( 'body' );

    $.DLMenu = function( options, element ) {

        //initialize once
        if ( ! this.init ) {
            this.$el = $( element );
            this._init( options );
        }
    };

    // the options
    $.DLMenu.defaults = {
        overlay: false,

        // classes for the animation effects
        animationClasses: {
            classin: 'dl-animate-in-5', // 1-5
            classout: 'dl-animate-out-5' // 1-5
        },

        // callback: click a link that has a sub menu
        // el is the link element (li); name is the level name
        onLevelClick: function() {
            return false;
        },

        // callback: click a link that does not have a sub menu
        // el is the link element (li); ev is the event obj
        onLinkClick: function() {
            return false;
        }
    };

    $.DLMenu.prototype = {
        _init: function( options ) {

            // options
            this.options = $.extend( true, {}, $.DLMenu.defaults, options );

            // animation end event name
            this.animEndEventName = 'animationend.dlmenu';

            // transition end event name
            this.transEndEventName = 'transitionend.dlmenu';

            // cache some elements and initialize some variables
            this._config();
            this._initEvents();

        },
        _config: function() {
            this.$trigger = this.$el.children( '.menu-trigger' );
            this.$menu = this.$el.find( '.analytica_mega' );
            this.$menuitems = this.$menu.find( 'li:not(.dl-back)' );

            // add elements
            if ( typeof this.$back === 'undefined' ) {
                this.$el.find( 'a' ).siblings( 'ul.sub-menu' ).prepend( '<li class="dl-back"><a href="#">back</a></li>' );
            }
            this.$back = this.$menu.find( '.dl-back' );
        },

        _initEvents: function() {

            var self = this;

            this.$trigger.toggle( function() {
                self.open = false;
                self._openMenu();
            }, function() {
                self._closeMenu();
            });

            this.$menuitems.on( 'click.dlmenu', function( event ) {

                event.stopPropagation();

                var $item = $( this ),
                    $submenu = $item.find( 'ul.sub-menu' );

                $item.find( 'div>ul>li>ul' ).removeClass( 'sub-menu' );

                if ( $submenu.length > 0 ) {

                    var $flyin = $submenu.clone().css( 'opacity', 0 ).addClass( 'submenu-clone' ).insertAfter( self.$menu ),
                        onAnimationEndFn = function() {
                           self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classout ).addClass( 'dl-subview' );
                           $item.addClass( 'dl-subviewopen' ).parents( '.dl-subviewopen:first' ).removeClass( 'dl-subviewopen' ).addClass( 'dl-subview' );
                           $flyin.remove();
                        };

                    setTimeout( function() {
                        $flyin.addClass( self.options.animationClasses.classin );
                        self.$menu.addClass( self.options.animationClasses.classout );
                        self.$menu.on( self.animEndEventName, onAnimationEndFn );
                        self.options.onLevelClick( $item, $item.children( 'a:first' ).text() );
                    });

                    if ( self.$el.find( 'ul.sub-menu' ).siblings( 'a' ).find( '.sub-indicator' ).length !== 0 ) {
                        self.$el.find( 'ul.sub-menu' ).siblings( 'a' ).append( '<span class="sub-indicator"></span>' );
                    }

                    event.preventDefault();

                } else {

                    self.options.onLinkClick( $item, event );

                }

            });

            this.$back.on( 'click.dlmenu', function() {

                var $this = $( this ),
                    $submenu = $this.parents( 'ul.sub-menu:first' ),
                    $item = $submenu.parent();

                var $flyin = $submenu.clone().addClass( 'submenu-clone back' ).insertAfter( self.$menu );

                var onAnimationEndFn = function() {
                   	self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classin );
                  	$flyin.remove();
                };

                setTimeout( function() {
                    $flyin.addClass( self.options.animationClasses.classout );
                    self.$menu.addClass( self.options.animationClasses.classin );
                    self.$menu.on( self.animEndEventName, onAnimationEndFn );
                    $item.removeClass( 'dl-subviewopen' );

                    var $subview = $this.parents( '.dl-subview:first' );

                    if ( $subview.is( 'li' ) ) {
                        $subview.addClass( 'dl-subviewopen' );
                    }

                    $subview.removeClass( 'dl-subview' );
                });

                return false;

            });

            // listen for destroyed, call teardown
            this.$el.on( 'destroyed.dlmenu', $.proxy( this.teardown, this ) );

            this.init = true;
        },

        closeMenu: function() {

            if ( this.open = true ) {
                this._closeMenu();
            }
        },

        _closeMenu: function() {

            var self = this,

            onTransitionEndFn = function() {
                self.$menu.off( self.transEndEventName );
                self._resetMenu();
            };

            self.$menu.removeClass( 'dl-menuopen' );

            self.$menu.addClass( 'dl-menu-toggle' );

            self.$trigger.removeClass( 'dl-active' );

            if ( self.supportTransitions ) {
                self.$menu.on( self.transEndEventName, onTransitionEndFn );
            } else {
                onTransitionEndFn.call();
            }

            //remove overlay
            $( '#menu-overlay' ).remove();

            self.open = false;
        },

        openMenu: function() {
            if ( ! this.open ) {
                this._openMenu();
            }
        },

        _openMenu: function() {
            var self = this;

            // clicking somewhere else makes the menu close
            $body.off( 'click' ).on( 'click.dlmenu', function() {
                self._closeMenu() ;
            });

            self.$menu.addClass( 'dl-menuopen dl-menu-toggle' ).on( self.transEndEventName, function() {
                $( this ).removeClass( 'dl-menu-toggle' );
            });

            self.$trigger.addClass( 'dl-active' );

            //create overlay
            if ( self.options.overlay ) {
                $( 'body' ).append( '<div id="menu-overlay" />' );
            }
            self.open = true;
        },

        // resets the menu to its original state (first level of options)
        _resetMenu: function() {
            this.$menu.removeClass( 'dl-subview' );
            this.$menuitems.removeClass( 'dl-subview dl-subviewopen' );
        },

        destroy: function() {
            this.$el.unbind( 'destroyed', this.teardown );
            this.teardown();
        },

        // set back our element
        teardown: function() {

            // roll back changes
            this.$menu.removeClass( 'dl-menuopen dl-menu-toggle' );
            this.$trigger.removeClass( 'dl-active' ).off();
            this._closeMenu();
            this.$el.find( 'ul.sub-menu .dl-back' ).remove();
            this.$el.removeClass( this.name );
            this.$menuitems.off();
            this.$back.off();
            this.$el.removeData();
            this.$el = null;
            this.init = null;
            this.open = null;
        }

    };

    var logError = function( message ) {
        if ( window.console ) {
            window.console.error( message );
        }
    };

    $.fn.dlmenu = function( options ) {
        if ( typeof options === 'string' ) {
            var args = Array.prototype.slice.call( arguments, 1 );
            this.each( function() {
                var instance = $.data( this, 'dlmenu' );
                if ( ! instance ) {
                    logError( 'cannot call methods on dlmenu prior to initialization; ' +
                        'attempted to call method \'' + options + '\'' );
                    return;
                }
                if ( ! $.isFunction( instance[options]) || options.charAt( 0 ) === '_' ) {
                    logError( 'no such method \'' + options + '\' for dlmenu instance' );
                    return;
                }
                instance[options].apply( instance, args );
            });
        } else {
            this.each( function() {
                var instance = $.data( this, 'dlmenu' );
                if ( instance ) {
                    instance._init();
                } else {
                    instance = $.data( this, 'dlmenu', new $.DLMenu( options, this ) );
                }
            });
        }
        return this;
    };

}( jQuery, window ) );
