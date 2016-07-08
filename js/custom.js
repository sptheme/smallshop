( function( $ ) {
	'use strict';

	var wpspCustom = {
		
		/**
		 * Main init function
		 *
		 * @since 1.0.0
		 */
		init : function() {
			this.config();
			this.bindEvents();
		},

		/**
		 * Cache Elements
		 *
		 * @since 1.0.0
		 */
		config : function() {

			this.config = {
				$window                 : $( window ),
				$document               : $( document ),
				$windowWidth            : $( window ).width(),
				$windowHeight           : $( window ).height(),
				$windowTop              : $( window ).scrollTop(),
				$body                   : $( 'body' ),
				$mobileMenuBreakpoint   : 960,
				$wpAdminBar             : null,
				$siteHeader             : null,
				$siteHeaderHeight       : 0,
				$siteHeaderTop          : 0,
				$siteHeaderBottom       : 0,
				$siteLogo               : null,
				$siteLogoHeight         : 0,
				$siteLogoSrc            : null,
				$siteNavWrap            : null,
				$localScrollOffset      : 0,
				$localScrollSpeed       : 600,
				$localScrollArray       : [],
				$mobileMenuStyle        : null,
				$hasFixedFooter         : false,
				$hasFooterReveal        : false,
				$hasTopBar              : false,
				$hasHeaderOverlay       : false,
				$hasStickyHeader        : false,
				$stickyHeaderBreakPoint : 960,
				$hasStickyMobileHeader  : false,
				$hasStickyTopBar        : false,
				$stickyTopBar           : null,
				$stickyTopBarHeight     : 0,
				$is_rtl                 : false,
				$retinaLogo             : null,
				$isMobile               : false,
				$verticalHeaderActive   : false,
				$isCustomizePreview     : false
			};

		},

		bindEvents: function() {
			var self = this;

			// Run on document ready
			self.config.$document.on( 'ready', function() {
				self.initUpdateConfig();
				self.pageAnimations();
				self.superFish();
				self.megaMenusWidth();
				self.mobileMenu();
				self.inlineHeaderLogo();
				self.menuSearch();
				self.headerCart();
				self.backTopLink();
				self.archiveMasonryGrids();
				self.customSelects();
				self.magnificPopup();
				self.owlCarousel();
			} );

			// Run on Window Load
			self.config.$window.on( 'load', function() {
				self.windowLoadUpdateConfig();
				self.megaMenusTop();
				self.flushDropdownsTop();
				self.equalHeights();
				self.sliderPro();
				
				// Delay functions if page animations are enabled
				if ( $.fn.animsition && wpspLocalize.pageAnimation && wpspLocalize.pageAnimationInDuration ) {
					setTimeout( function() {
						self.stickyHeader();
						self.stickyHeaderShrink();
					}, wpspLocalize.pageAnimationInDuration );
				} else {
					self.stickyHeader();
					self.stickyHeaderShrink();
				}

				// Footer Reveal => Must run before fixed footer!!!
				self.footerRevealInit();

				// Fixed Footer
				self.fixedFooter();

			} );

			// Run on Window Resize
			self.config.$window.resize( function() {
				// Window width change
				if ( self.config.$window.width() != self.config.$windowWidth ) {
					self.resizeUpdateConfig();
					self.megaMenusWidth();
					self.inlineHeaderLogo();
					self.fixedFooter();
					self.footerRevealInit();
				}

				// Window height change
				if ( self.config.$window.height() != self.config.$windowHeight ) {
					self.fixedFooter();
					self.footerRevealInit();
				}
			} );

			// Run on Scroll
			self.config.$window.scroll( function() {
				self.config.$windowTop = self.config.$window.scrollTop();
				self.footerRevealScrollShow();
			} );

			// On orientation change
			self.config.$window.on( 'orientationchange',function() {
				resizeUpdateConfig();
				self.inlineHeaderLogo();
				self.archiveMasonryGrids();
			} );
		},

		/**
		 * Updates config on doc ready
		 *
		 * @since 1.0.0
		 */
		initUpdateConfig: function() {

			// Mobile check & add mobile class to the header
			this.config.$isMobile = this.mobileCheck();
			if ( this.config.$isMobile ) {
				this.config.$body.addClass( 'wpsp-is-mobile-device' );
			}

			// Local scroll speed
			if ( wpspLocalize.localScrollSpeed ) {
				this.config.$localScrollSpeed = parseInt( wpspLocalize.localScrollSpeed );
			}

			// Define Wp admin bar
			var $wpAdminBar = $( '#wpadminbar' );
			if ( $wpAdminBar.length ) {
				this.config.$wpAdminBar = $wpAdminBar;
			}

			// Define header
			if ( $( '#site-header' ).length ) {
				this.config.$siteHeader = $( '#site-header' );
			}

			// Define logo
			if ( $( '#site-logo img' ).length ) {
				this.config.$siteLogo = $( '#site-logo img' );
				this.config.$siteLogoSrc = this.config.$siteLogo.attr( 'src' );
			}

			// Site nav wrap
			if ( $( '#site-navigation-wrap' ).length ) {
				this.config.$siteNavWrap = $( '#site-navigation-wrap' );
			}

			// Mobile menu style
			if ( $( '#site-navigation-wrap' ).length ) {
				this.config.$mobileMenuStyle = wpspLocalize.mobileMenuStyle;
			}

			// Check if fixed footer is enabled
			if ( this.config.$body.hasClass( 'wpsp-has-fixed-footer' ) ) {
				this.config.$hasFixedFooter = true;
			}
			
			// Footer reveal
			if ( $( '.footer-reveal' ).length && $( '#wrap' ).length && $( '#content' ).length ) {
				this.config.$hasFooterReveal = true;
			}

			// Vertical header
			if ( this.config.$body.hasClass( 'wpsp-has-vertical-header' ) ) {
				this.config.$verticalHeaderActive = true;
			}

			// Sticky Header
			if ( wpspLocalize.hasStickyHeader ) {
				if ( wpspLocalize.stickyHeaderBreakPoint ) {
					this.config.$stickyHeaderBreakPoint = wpspLocalize.stickyHeaderBreakPoint;
				}
				if ( this.config.$hasStickyMobileHeader || ( this.config.$windowWidth >= this.config.$stickyHeaderBreakPoint ) ) {
					this.config.$hasStickyHeader = true;
				} else {
					this.config.$hasStickyHeader = false;
				}
			}
		},

		/**
		 * Updates config on window load
		 *
		 * @since 1.0.0
		 */
		windowLoadUpdateConfig: function() {

			// Header bottom position
			if ( this.config.$siteHeader ) {
				var $siteHeaderTop = this.config.$siteHeader.offset().top;
				this.config.$windowHeight = this.config.$window.height();
				this.config.$siteHeaderHeight = this.config.$siteHeader.outerHeight();
				this.config.$siteHeaderBottom = $siteHeaderTop + this.config.$siteHeaderHeight;
				this.config.$siteHeaderTop = $siteHeaderTop;
				if ( this.config.$siteLogo ) {
					this.config.$siteLogoHeight = this.config.$siteLogo.height();
				}
			}

			// Update Topbar sticky height
			if ( this.config.$stickyTopBar ) {
				this.config.$stickyTopBarHeight = this.config.$stickyTopBar.outerHeight();
				$( '.wpsp-sticky-top-bar-holder' ).height( this.config.$stickyTopBarHeight );
			}

			// Set localScrollOffset after site is loaded to make sure it includes dynamic items
			this.config.$localScrollOffset = this.parseLocalScrollOffset();

		},

		/**
		 * Updates config whenever the window is resized
		 *
		 * @since 1.0.0
		 */
		resizeUpdateConfig: function() {

			// Update main configs
			this.config.$windowHeight = this.config.$window.height();
			this.config.$windowWidth  = this.config.$window.width();
			this.config.$windowTop    = this.config.$window.scrollTop();

			// Update header height
			if ( this.config.$siteHeader ) {

				// reset sticky height
				if ( $( '.wpsp-sticky-header-holder' ).length ) {
					$( '.wpsp-sticky-header-holder' ).height( '' );
				}

				// Get header height
				this.config.$siteHeaderHeight = this.config.$siteHeader.outerHeight();

				// Re add sticky height
				if ( $( '.wpsp-sticky-header-holder' ).length ) {
					$( '.wpsp-sticky-header-holder' ).height( this.config.$siteHeaderHeight );
				}

			}

			// Get logo height
			if ( this.config.$siteLogo ) {
				this.config.$siteLogoHeight = this.config.$siteLogo.height();
			}

			// Vertical Header
			if ( this.config.$windowWidth < 960 ) {
				this.config.$verticalHeaderActive = false;
			} else if ( this.config.$body.hasClass( 'wpsp-has-vertical-header' ) ) {
				this.config.$verticalHeaderActive = true;
			}

			// Update Topbar sticky height
			if ( this.config.$stickyTopBar ) {
				this.config.$stickyTopBarHeight = this.config.$stickyTopBar.outerHeight();
				$( '.wpsp-sticky-top-bar-holder' ).height( this.config.$stickyTopBarHeight );
			}

			// Re-stick topbar but check for mobile first
			if ( this.config.$hasStickyTopBar ) {

				// Unstick first
				this.stickyTopBar( 'unstick' );

				// Desktops or mobile enabled
				if ( wpspLocalize.hasStickyTopBarMobile || ( this.config.$windowWidth >= wpspLocalize.stickyTopBarBreakPoint ) ) {
					this.config.$hasStickyTopBar = true;
					this.stickyTopBar();
				}

				// Mobile
				else if ( ! wpspLocalize.hasStickyTopBarMobile ) {
					this.config.$hasStickyTopBar = false;
				}

			}

			// Sticky Header
			if ( this.config.$hasStickyHeader ) {

				// Unstick first
				this.stickyHeader( 'unstick' );
				this.stickyHeaderShrink( 'destroy' );

				// Desktops
				if ( this.config.$hasStickyMobileHeader || ( this.config.$windowWidth >= wpspLocalize.stickyHeaderBreakPoint ) ) {
					this.config.$hasStickyHeader = true;
					this.stickyHeader();
					this.stickyHeaderShrink();
				}

				// Mobile
				else if ( ! this.config.$hasStickyMobileHeader ) {
					this.config.$hasStickyHeader = false;
				}

			}

			// Local scroll offset => update last
			this.config.$localScrollOffset = this.parseLocalScrollOffset();

		},

		/**
		 * Mobile Check
		 *
		 * @since 1.0.0
		 */
		mobileCheck: function() {
			if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
				return true;
			}
		},

		/**
		 * Page Animations
		 *
		 * @since 1.0.0
		 */
		pageAnimations: function() {

			if ( ! $.fn.animsition ) {
				return;
			}

			// Return if wrapper doesn't exist
			if ( ! wpspLocalize.pageAnimation ) {
				return;
			}

			// Run animsition
			$( '.animsition' ).animsition( {
				touchSupport: false,
				inClass: wpspLocalize.pageAnimationIn,
				outClass: wpspLocalize.pageAnimationOut,
				inDuration: wpspLocalize.pageAnimationInDuration,
				outDuration: wpspLocalize.pageAnimationOutDuration,
				linkElement: 'a[href]:not([target="_blank"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([href*="?"]):not([href*="#localscroll"]):not([class="wcmenucart"])',
				loading: true
			} );

		},

	    superFish: function() {
	        if ( ! $.fn.superfish ) {
				return;
			}

			$( '#site-navigation ul.sf-menu' ).superfish( {
				delay: wpspLocalize.superfishDelay,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: wpspLocalize.superfishSpeed,
				speedOut: wpspLocalize.superfishSpeedOut,
				cssArrows: false,
				disableHI: false
			} );
	    },

	     /**
		 * MegaMenus Width
		 *
		 * @since 1.0.0
		 */
		megaMenusWidth: function() {

			if ( ! this.config.$siteHeader || wpspLocalize.siteHeaderStyle !== 'one' ) {
				return;
			}

			var $siteNavigationWrap         = $( '#site-navigation-wrap' ),
				$headerContainerWidth       = this.config.$siteHeader.find( '.container' ).outerWidth(),
				$navWrapWidth               = $siteNavigationWrap.outerWidth(),
				$siteNavigationWrapPosition = $siteNavigationWrap.css( 'right' ),
				$siteNavigationWrapPosition = parseInt( $siteNavigationWrapPosition );

			if ( 'auto' == $siteNavigationWrapPosition ) {
				$siteNavigationWrapPosition = 0;
			}

			var $megaMenuNegativeMargin = $headerContainerWidth-$navWrapWidth-$siteNavigationWrapPosition;

			$( '#site-navigation-wrap .megamenu > ul' ).css( {
				'width'       : $headerContainerWidth,
				'margin-left' : -$megaMenuNegativeMargin
			} );

		},

		/**
		 * MegaMenus Top Position
		 *
		 * @since 1.0.0
		 */
		megaMenusTop: function() {

			if ( ! this.config.$siteHeaderHeight
				|| ! this.config.$siteNavWrap
				|| ! this.config.$siteHeader.hasClass( 'header-one' )
				|| $( '#site-navigation-wrap' ).hasClass( 'wpsp-flush-dropdowns' )
				|| ! this.config.$siteHeader.hasClass( 'header-one' )
			) {
				return;
			}

			var $navHeight = this.config.$siteNavWrap.outerHeight(),
				$megaMenuTop = this.config.$siteHeaderHeight - $navHeight;

			$( '#site-navigation-wrap .megamenu > ul' ).css( {
				'top': $megaMenuTop/2 + $navHeight
			} );

		},

		/**
		 * FlushDropdowns top positioning
		 *
		 * @since 1.0.0
		 */
		flushDropdownsTop: function() {

			if ( ! this.config.$siteHeaderHeight
				|| ! this.config.$siteNavWrap
				|| ! this.config.$siteNavWrap.hasClass( 'wpsp-flush-dropdowns' )
			) {
				return;
			}

			var $navHeight = this.config.$siteNavWrap.outerHeight(),
				$dropTop = this.config.$siteHeaderHeight - $navHeight;

			$( '#site-navigation-wrap .dropdown-menu > .menu-item-has-children > ul' ).css( {
				'top': $dropTop/2 + $navHeight
			} );

		},

		/**
		 * Mobile Menu
		 *
		 * @since 1.0.0
		 */
		mobileMenu: function( event ) {

			var self = this;

			/***** Sidr Mobile Menu ****/
			if ( 'sidr' == this.config.$mobileMenuStyle && typeof wpspLocalize.sidrSource !== 'undefined' ) {

				var self = this;

				// Add sidr
				$( 'a.mobile-menu-toggle, li.mobile-menu-toggle > a' ).sidr( {
					name     : 'sidr-main',
					source   : wpspLocalize.sidrSource,
					side     : wpspLocalize.sidrSide,
					displace : wpspLocalize.sidrDisplace,
					speed    : parseInt( wpspLocalize.sidrSpeed ),
					renaming : true,
					onOpen   : function() {

						// Add extra classname
						$( '#sidr-main' ).addClass( 'wpsp-mobile-menu' );

						// Prevent body scroll
						self.config.$body.addClass( 'wpsp-noscroll' );

						// Declare useful vars
						var $hasChildren = $( '.sidr-class-menu-item-has-children' );

						// Add dropdown toggle (arrow)
						$hasChildren.children( 'a' ).append( '<span class="sidr-class-dropdown-toggle"></span>' );

						// Toggle dropdowns
						var $sidrDropdownTarget = $( '.sidr-class-dropdown-toggle' );

						// Check localization
						if ( wpspLocalize.sidrDropdownTarget == 'li' ) {
							$sidrDropdownTarget = $( '.sidr-class-sf-with-ul' );
						}

						// Add toggle click event
						$sidrDropdownTarget.on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {

							// Define toggle vars
							if ( wpspLocalize.sidrDropdownTarget == 'li' ) {
								var $toggleParentLi = $( this ).parent( 'li' );
							} else {
								var $toggleParentLink = $( this ).parent( 'a' ),
									$toggleParentLi   = $toggleParentLink.parent( 'li' );
							}

							// Get parent items and dropdown
							var $allParentLis = $toggleParentLi.parents( 'li' ),
								$dropdown     = $toggleParentLi.children( 'ul' );

							// Toogle items
							if ( ! $toggleParentLi.hasClass( 'active' ) ) {
								$hasChildren.not( $allParentLis ).removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
								$toggleParentLi.addClass( 'active' ).children( 'ul' ).slideDown( 'fast' );
							} else {
								$toggleParentLi.removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
							}

							// Return false
							return false;

						} );

						// Add dark overlay to content
						self.config.$body.append( '<div class="wpsp-sidr-overlay wpsp-hidden"></div>' );
						$( '.wpsp-sidr-overlay' ).fadeIn( wpspLocalize.sidrSpeed );

						// Bind scroll
						$( '#sidr-main' ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
							var e0 = e.originalEvent,
								delta = e0.wheelDelta || -e0.detail;
							this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
							e.preventDefault();
						} );

						// Close sidr when clicking toggle
						$( 'a.sidr-class-toggle-sidr-close' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
							$.sidr( 'close', 'sidr-main' );
							return false;
						} );

						// Close sidr when clicking on overlay
						$( '.wpsp-sidr-overlay' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
							$.sidr( 'close', 'sidr-main' );
							return false;
						} );

						// Close on resize
						self.config.$window.resize( function() {
							if ( self.config.$windowWidth >= self.config.$mobileMenuBreakpoint ) {
								$.sidr( 'close', 'sidr-main' );
							}
						} );

					},
					onClose : function() {

						// Allow body scroll
						self.config.$body.removeClass( 'wpsp-noscroll' );

						// Remove active dropdowns
						$( '.sidr-class-menu-item-has-children.active' ).removeClass( 'active' ).children( 'ul' ).hide();
						
						// FadeOut overlay
						$( '.wpsp-sidr-overlay' ).fadeOut( wpspLocalize.sidrSpeed, function() {
							$( this ).remove();
						} );
					}

				} );

				// Close when clicking local scroll link
				$( 'li.sidr-class-local-scroll > a' ).click( function() {
					var $hash = this.hash;
					if ( $.inArray( $hash, self.config.$localScrollArray ) > -1 ) {
						$.sidr( 'close', 'sidr-main' );
						self.scrollTo( $hash );
						return false;
					}
				} );

			}

			/***** Toggle Mobile Menu ****/
			else if ( 'toggle' == self.config.$mobileMenuStyle && self.config.$siteHeader ) {

				var $classes = 'mobile-toggle-nav wpsp-mobile-menu clear';

				// Insert nav
				if ( $( '#wpsp-mobile-menu-fixed-top' ).length ) {
					$( '#wpsp-mobile-menu-fixed-top' ).append( '<nav class="'+ $classes +'"></nav>' );
				}

				// Overlay header
				else if ( self.config.$hasHeaderOverlay && $( '#overlay-header-wrap' ).length ) {
					$( '<nav class="'+ $classes +'"></nav>' ).insertBefore( "#overlay-header-wrap" );
				}

				// Normal toggle insert
				else {
					$( '<nav class="'+ $classes +'"></nav>' ).insertAfter( self.config.$siteHeader );
				}

				// Grab all content from menu and add into mobile-toggle-nav element
				if ( $( '#mobile-menu-alternative' ).length ) {
					var mobileMenuContents = $( '#mobile-menu-alternative .dropdown-menu' ).html();
				} else {
					var mobileMenuContents = $( '#site-navigation .dropdown-menu' ).html();
				}
				$( '.mobile-toggle-nav' ).html( '<ul class="mobile-toggle-nav-ul">' + mobileMenuContents + '</ul>' );

				// Remove all styles
				$( '.mobile-toggle-nav-ul, .mobile-toggle-nav-ul *' ).children().each( function() {
					var attributes = this.attributes;
					$( this ).removeAttr( 'style' );
				} );

				// Add classes where needed
				$( '.mobile-toggle-nav-ul' ).addClass( 'container' );

				// Show/Hide
				$( '.mobile-menu-toggle' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					if ( wpspLocalize.animateMobileToggle ) {
						$( '.mobile-toggle-nav' ).stop(true,true).slideToggle( 'fast' ).toggleClass( 'visible' );
					} else {
						$( '.mobile-toggle-nav' ).toggle().toggleClass( 'visible' );
					}
					return false;
				} );

				// Close on resize
				self.config.$window.resize( function() {
					if ( self.config.$windowWidth >= self.config.$mobileMenuBreakpoint && $( '.mobile-toggle-nav' ).length ) {
						$( '.mobile-toggle-nav' ).hide().removeClass( 'visible' );
					}
				} );

				// Add search to toggle menu
				var $mobileSearch = $( '#mobile-menu-search' );
				if ( $mobileSearch.length ) {
					$( '.mobile-toggle-nav' ).append( '<div class="mobile-toggle-nav-search container"></div>' );
					$( '.mobile-toggle-nav-search' ).append( $mobileSearch );
				}

			}

			/***** Full-Screen Overlay Mobile Menu ****/
			else if ( 'full_screen' == self.config.$mobileMenuStyle && self.config.$siteHeader ) {

				// Style
				var $style = wpspLocalize.fullScreenMobileMenuStyle ? wpspLocalize.fullScreenMobileMenuStyle : false;

				// Insert new nav
				self.config.$body.append( '<div class="full-screen-overlay-nav wpsp-mobile-menu clear '+ $style +'"><span class="full-screen-overlay-nav-close"></span><nav class="full-screen-overlay-nav-ul-wrapper"><ul class="full-screen-overlay-nav-ul"></ul></nav></div>' );

				// Grab all content from menu and add into mobile-toggle-nav element
				if ( $( '#mobile-menu-alternative' ).length ) {
					var mobileMenuContents = $( '#mobile-menu-alternative .dropdown-menu' ).html();
				} else {
					var mobileMenuContents = $( '#site-navigation .dropdown-menu' ).html();
				}
				$( '.full-screen-overlay-nav-ul' ).html( mobileMenuContents );

				// Remove all styles
				$( '.full-screen-overlay-nav, .full-screen-overlay-nav *' ).children().each( function() {
					var attributes = this.attributes;
					$( this ).removeAttr( 'style' );
				} );

				// Show
				$( '.mobile-menu-toggle' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					$( '.full-screen-overlay-nav' ).addClass( 'visible' );
					self.config.$body.addClass( 'wpsp-noscroll' );
					return false;
				} );

				// Hide
				$( '.full-screen-overlay-nav-close' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					$( '.full-screen-overlay-nav' ).removeClass( 'visible' );
					self.config.$body.removeClass( 'wpsp-noscroll' );
					return false;
				} );

			}

		},

	    /**
		 * Sticky Header
		 *
		 * @since 1.0.0
		 */
		stickyHeader: function( event ) {

			var self        = this,
				$fixedNav   = $( '.fixed-nav' ),
				$topSpacing = 0,
				$mobileMenu = $( '#wpsp-mobile-menu-fixed-top' );

			// Destroy sticky and sticky functions
			if ( 'unstick' == event ) {

				if ( $( '.wpsp-sticky-header-holder' ).length ) {

					// Destroy shrink header
					self.stickyHeaderShrink( 'resize_destroy' );

					// Destroy sticky header
					$( '#site-header.fixed-scroll' ).unstick();

					// Set correct header height
					$( '.wpsp-sticky-header-holder' ).css( 'height', '' );

					// Return correct logo
					var $logo = self.config.retinaLogo ? self.config.retinaLogo : self.config.$siteLogoSrc;
					if ( $logo ) {
						self.config.$siteLogo.attr( 'src', $logo );
					}

				}

				if ( $( '.wpsp-sticky-menu-holder' ).length ) {
					$( '.fixed-nav' ).unstick();
				}

			}

			// Add Sticky
			else {

				// Sticky is disabled do nothing or header doesn't exist...return
				if ( ! this.config.$siteHeader
					|| ! this.config.$hasStickyHeader
				) {
				   return;
				}

				if ( self.config.$hasStickyTopBar ) {
					$topSpacing = $topSpacing + self.config.$stickyTopBar.outerHeight()
				}
				if ( $mobileMenu.is( ':visible' ) ) {
					$topSpacing = $topSpacing + $mobileMenu.outerHeight();
				}

				// Already sticky do nothing
				if ( $( '.wpsp-sticky-header-holder' ).length ) {
					return;
				}

				// Sticky header
				if ( self.config.$siteHeader.hasClass( 'fixed-scroll' ) ) {

					// Start sticky
					self.config.$siteHeader.sticky( {
						topSpacing       : $topSpacing,
						getWidthFrom     : '#wrap',
						responsiveWidth  : true,
						wrapperClassName : 'wpsp-sticky-header-holder'
					} );

					// Set header height
					$( '.wpsp-sticky-header-holder' ).height( self.config.$siteHeaderHeight );

					// Sticky on start events
					self.config.$siteHeader.on( 'sticky-start', function() {

						// Sticky custom logo
						if ( self.config.$siteLogo
							&& wpspLocalize.stickyheaderCustomLogo
							&& ! self.config.$siteHeader.hasClass( 'wpsp-shrink-sticky-header' )
						) {
							self.config.$siteLogo.attr( 'src', wpspLocalize.stickyheaderCustomLogo );
						}

					} );

					// Sticky on end events
					self.config.$siteHeader.on( 'sticky-end', function() {

						// Return correct logo
						if ( ! self.config.$siteHeader.hasClass( 'wpsp-shrink-sticky-header' ) ) {
							var $logo = self.config.retinaLogo ? self.config.retinaLogo : self.config.$siteLogoSrc;
							if ( $logo ) {
								self.config.$siteLogo.attr( 'src', $logo );
							}
						}

					} );

				} 

				// Sticky nav
				else if ( $fixedNav.length ) {

					$fixedNav.sticky( {
						topSpacing       : $topSpacing,
						getWidthFrom     : '#wrap',
						responsiveWidth  : true,
						wrapperClassName : 'wpsp-sticky-menu-holder'
					} );

					// Sticky on start events
					$fixedNav.on( 'sticky-start', function() {
						$( '.wpsp-sticky-menu-holder' ).height( $fixedNav.outerHeight() );
					} );

					// Sticky on end events
					$fixedNav.on( 'sticky-end', function() {
						$( '.wpsp-sticky-menu-holder' ).height('');
					} );

				}

			}

		},

		/**
		 * Shrink sticky header
		 *
		 * @since 1.0.0
		 */
		stickyHeaderShrink: function( event ) {

			// Initial checks
			if ( ! this.config.$siteHeader
				|| ! this.config.$siteHeader.hasClass( 'wpsp-shrink-sticky-header' )
				|| ! $( '.wpsp-sticky-header-holder' ).length
			) {
				return;
			}

			// Declare main vars
			var self = this,
				$siteHeaderInner  = $( '#site-header-inner' ),
				$ogTopPadding     = $( '#site-header-inner' ).css( 'padding-top' ),
				$ogBottomPadding  = $( '#site-header-inner' ).css( 'padding-bottom' ),
				$ogHeight         = $siteHeaderInner.outerHeight(),
				$shrunkHeight     = parseInt( wpspLocalize.shrinkHeaderHeight ),
				$shrunkSpeed      = 300;

			// Shurnk logo height
			if ( wpspLocalize.shrinkHeaderLogoHeight ) {
				var $shrunkHeightLogo = wpspLocalize.shrinkHeaderLogoHeight;
			} else {
				var $shrunkHeightLogo = 50;
				if ( $shrunkHeightLogo > self.config.$siteLogoHeight ) {
					$shrunkHeightLogo = self.config.$siteLogoHeight - 10;
				}
			}
			$shrunkHeightLogo = parseInt( $shrunkHeightLogo );
			
			// Destroy method
			function destroy() {

				if ( self.config.$siteHeader.hasClass( 'wpsp-header-shrunk' ) ) {
					
					// Reset header height
					$siteHeaderInner.stop(true,true).animate( {
						'height'         : $ogHeight,
						'padding-top'    : $ogTopPadding,
						'padding-bottom' : $ogBottomPadding
					}, {
						duration: $shrunkSpeed,
						queue: false
					} );

					// Reset logo
					var $logo = self.config.retinaLogo ? self.config.retinaLogo : self.config.$siteLogoSrc;
					if ( $logo ) {
						self.config.$siteLogo.attr( 'src', $logo );
					}

					// Reset logo height
					if ( self.config.$siteLogo ) {
						self.config.$siteLogo.stop(true,true).animate( {
							'height' : self.config.$siteLogoHeight
						}, {
							duration : $shrunkSpeed,
							queue    : false,
							complete : function() {
								$( this ).css( 'height', '' );
							}
						} );
					}

					// Get correct header height after animations are complete and re-position megamenus
					setTimeout( function() {
						self.config.$siteHeaderHeight = self.config.$siteHeader.outerHeight();
						self.megaMenusTop();
						self.flushDropdownsTop();
					}, $shrunkSpeed );

					// Remove shrunk class
					self.config.$siteHeader.removeClass( 'wpsp-header-shrunk' );

				}
			}

			// Destroy event
			if ( 'destroy' == event ) {
				destroy();
				return;
			}

			// Resize destroy method - required since header height can change on window resize
			function resizeDestroy() {

				if ( ! $shrunkHeight ) {
					return;
				}

				// Reset header height
				$siteHeaderInner.css( {
					'height'         : '',
					'padding-top'    : '',
					'padding-bottom' : ''
				} );

				// Reset logo
				var $logo = self.config.retinaLogo ? self.config.retinaLogo : self.config.$siteLogoSrc;
				if ( $logo ) {
					self.config.$siteLogo.attr( 'src', $logo );
				}

				// Reset logo height
				if ( self.config.$siteLogo ) {
					self.config.$siteLogo.css( 'height', '' );
				}

				// Get correct header height and megaMenus top location
				self.config.$siteHeaderHeight = self.config.$siteHeader.outerHeight();
				self.megaMenusTop();
				self.flushDropdownsTop();

				// Remove shrunk class
				self.config.$siteHeader.removeClass( 'wpsp-header-shrunk' );

			}

			if ( 'resize_destroy' == event ) {
				resizeDestroy();
				return;
			}

			// Get offset
			var $offSet = 0;
			if ( self.config.$siteHeaderBottom ) {
				$offSet = self.config.$siteHeaderBottom;
			}

			self.config.$window.scroll( function() {

				// Sticky header disabled = must check on scroll
				if ( ! self.config.$hasStickyHeader ) {
					return;
				}

				// Add shrink classes
				if ( self.config.$windowTop > $offSet ) {

					if ( ! self.config.$siteHeader.hasClass( 'wpsp-header-shrunk' ) ) {
						
						// Set header innner height
						$siteHeaderInner.stop(true,true).animate( {
							'height'         : $shrunkHeight,
							'padding-top'    : '0',
							'padding-bottom' : '0'
						}, {
							'duration' : $shrunkSpeed,
							'queue'    : false
						} );

						// Set logo height
						if ( self.config.$siteLogo ) {
							self.config.$siteLogo.stop(true,true).animate( {
								'height' : $shrunkHeightLogo
							}, {
								'duration' : $shrunkSpeed,
								'queue'    : false
							} );
						}

						// Sticky custom logo
						if ( self.config.$siteLogo && wpspLocalize.stickyheaderCustomLogo ) {
							self.config.$siteLogo.attr( 'src', wpspLocalize.stickyheaderCustomLogo );
						}

						// Get correct header height after animations are complete and re-position megamenus
						setTimeout( function() {
							self.config.$siteHeaderHeight = self.config.$siteHeader.outerHeight();
							self.megaMenusTop();
							self.flushDropdownsTop();
						}, $shrunkSpeed );

						// Add class to prevent events from running every time user scrolls
						self.config.$siteHeader.addClass( 'wpsp-header-shrunk' );

					}

				} else {

					destroy(); // As a function so we can destroy when sticky is destroyed also

				}

			} );

		},

		/**
		 * Header Search
		 *
		 * @since 1.0.0
		 */
		menuSearch: function() {

			var self = this;

			/**** Menu Search > Dropdown ****/
			if ( 'drop_down' == wpspLocalize.menuSearchStyle ) {

				var $searchDropdownToggle = $( 'a.search-dropdown-toggle' );
				var $searchDropdownForm   = $( '#searchform-dropdown' );

				$searchDropdownToggle.click( function( event ) {
					// Display search form
					$searchDropdownForm.toggleClass( 'show' );
					// Active menu item
					$( this ).parent( 'li' ).toggleClass( 'active' );
					// Focus
					var $transitionDuration = $searchDropdownForm.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						setTimeout( function() {
							$searchDropdownForm.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Hide other things
					$( 'div#current-shop-items-dropdown' ).removeClass( 'show' );
					$( 'li.wcmenucart-toggle-dropdown' ).removeClass( 'active' );
					// Return false
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( '#searchform-dropdown.show' ).length ) {
						$searchDropdownToggle.parent( 'li' ).removeClass( 'active' );
						$searchDropdownForm.removeClass( 'show' );
					}
				} );

			}

			/**** Menu Search > Overlay Modal ****/
			else if ( 'overlay' == wpspLocalize.menuSearchStyle ) {

				if ( ! $.fn.leanerModal ) {
					return;
				}

				var $searchOverlayToggle = $( 'a.search-overlay-toggle' );

				$searchOverlayToggle.leanerModal( {
					'id'      : '#searchform-overlay',
					'top'     : 100,
					'overlay' : 0.8,
				} );

				$searchOverlayToggle.click( function() {
					$( '#site-searchform input' ).focus();
				} );

			}
			
			/**** Menu Search > Header Replace ****/
			else if ( 'header_replace' == wpspLocalize.menuSearchStyle ) {

				// Show
				var $headerReplace = $( '#searchform-header-replace' );
				$( 'a.search-header-replace-toggle' ).click( function( event ) {
					// Display search form
					$headerReplace.toggleClass( 'show' );
					// Focus
					var $transitionDuration =  $headerReplace.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						setTimeout( function() {
							$headerReplace.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Return false
					return false;
				} );

				// Close on click
				$( '#searchform-header-replace-close' ).click( function() {
					$headerReplace.removeClass( 'show' );
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( $( '#searchform-header-replace.show' ) ).length ) {
						$headerReplace.removeClass( 'show' );
					}
				} );
			}

		},

		/**
		 * Header 5 - Inline Logo
		 *
		 * @since 1.0.0
		 */
		inlineHeaderLogo: function() {

			// Only needed for header style 5
			if ( 'five' != wpspLocalize.siteHeaderStyle ) {
				return;
			}

			var $headerLogo        = $( '#site-header-inner > .header-five-logo' ),
				$headerNav         = $( '#site-header-inner .navbar-style-five' ),
				$navLiCount        = $headerNav.children( '#site-navigation' ).children( 'ul' ).children( 'li' ).size(),
				$navBeforeMiddleLi = Math.round( $navLiCount / 2 ) - parseInt( wpspLocalize.headerFiveSplitOffset ),
				$centeredLogo      = $( '.menu-item-logo .header-five-logo' );

				// Add logo into menu
				if ( this.config.$windowWidth >= this.config.$mobileMenuBreakpoint && $headerLogo.length && $headerNav.length ) {
					$('<li class="menu-item-logo"></li>').insertAfter( $headerNav.find( '#site-navigation > ul > li:nth( '+ $navBeforeMiddleLi +' )' ) );
						$headerLogo.appendTo( $headerNav.find( '.menu-item-logo' ) );
				}

				// Remove logo from menu and add to header
				if ( this.config.$windowWidth < this.config.$mobileMenuBreakpoint && $centeredLogo.length ) {
					$centeredLogo.prependTo( $( '#site-header-inner' ) );
					$( '.menu-item-logo' ).remove();
				}

			// Add display class to logo (hidden by default)
			$headerLogo.addClass( 'display' );

		},

		/**
		 * Header Cart
		 *
		 * @since 1.0.0
		 */
		headerCart: function() {

			if ( $( 'a.wcmenucart' ).hasClass( 'go-to-shop' ) ) {
				return;
			}

			// Drop-down
			if ( 'drop_down' == wpspLocalize.wooCartStyle ) {

				// Display cart dropdown
				$( '.toggle-cart-widget' ).click( function( event ) {
					$( '#searchform-dropdown' ).removeClass( 'show' );
					$( 'a.search-dropdown-toggle' ).parent( 'li' ).removeClass( 'active' );
					$( 'div#current-shop-items-dropdown' ).toggleClass( 'show' );
					$( this ).toggleClass( 'active' );
					return false;
				} );

				// Hide cart dropdown
				$( 'div#current-shop-items-dropdown' ).click( function( event ) {
					event.stopPropagation(); 
				} );
				this.config.$document.click( function() {
					$( 'div#current-shop-items-dropdown' ).removeClass( 'show' );
					$( 'li.wcmenucart-toggle-dropdown' ).removeClass( 'active' );
				} );

				/* Prevent body scroll on current shop dropdown - seems buggy...
				$( '#current-shop-items-dropdown' ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
					var e0 = e.originalEvent,
						delta = e0.wheelDelta || -e0.detail;
					this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
					e.preventDefault();
				} );*/

			}

			// Modal
			else if ( 'overlay' == wpspLocalize.wooCartStyle ) {

				if ( ! $.fn.leanerModal ) {
					return;
				}

				$( '.toggle-cart-widget' ).leanerModal( {
					id: '#current-shop-items-overlay',
					top: 100,
					overlay: 0.8
				} );

			}

		},

		/**
		 * Back to top link
		 *
		 * @since 1.0.0
		 */
		backTopLink: function() {

			var self = this,
				$scrollTopLink = $( 'a#site-scroll-top' );

			if ( $scrollTopLink.length ) {

				var $speed = wpspLocalize.windowScrollTopSpeed ? wpspLocalize.windowScrollTopSpeed : 2000,
					$speed = parseInt( $speed );

				this.config.$window.scroll( function() {
					if ( $( this ).scrollTop() > 100 ) {
						$scrollTopLink.addClass( 'show' );
					} else {
						$scrollTopLink.removeClass( 'show' );
					}
				} );

				$scrollTopLink.on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					$( 'html, body' ).stop(true,true).animate( {
						scrollTop : 0
					}, $speed );
					return false;
				} );

			}
		},

		/**
		 * Isotope Grids
		 *
		 * @since 1.0.0
		 */
		archiveMasonryGrids: function() {

			// Define main vars
			var self      = this,
				$archives = $( '.blog-masonry-grid,div.wpsp-row.portfolio-masonry,div.wpsp-row.portfolio-no-margins,div.wpsp-row.staff-masonry,div.wpsp-row.staff-no-margins' );

			// Loop through archives
			$archives.each( function() {

				var $this               = $( this ),
					$data               = $this.data(),
					$transitionDuration = self.parseData( $data.transitionDuration, '0.0' ),
					$layoutMode         = self.parseData( $data.layoutMode, 'masonry' );

				// Load isotope after images loaded
				$this.imagesLoaded( function() {
					$this.isotope( {
						itemSelector       : '.isotope-entry',
						transformsEnabled  : true,
						isOriginLeft       : self.config.$isRTL ? false : true,
						transitionDuration : $transitionDuration + 's'
					} );
				} );

			} );
		},

		/**
		 * Equal heights function
		 *
		 * @since 1.0.0
		 */
		equalHeights: function() {

			// Make sure equal heights function is defined
			if ( ! $.fn.matchHeight ) {
				return;
			}
			
			// Add equal heights
			$( '.equal-height-column, .match-height-row .match-height-content, .vcex-feature-box-match-height .vcex-match-height, .equal-height-content, .match-height-grid .match-height-content, .blog-entry-equal-heights .blog-entry-inner, .wpsp-vc-row-columns-match-height .wpsp-vc-column-wrapper' ).matchHeight();

		},

		/**
		 * OwlCarousel
		 *
		 * @since 1.0.0
		 */
		owlCarousel: function() {

			var self = this;
			
			$( '.wpsp-carousel' ).each( function() {

				var $this = $( this ),
					$data = $this.data();

				$this.owlCarousel( {
					animateIn          : false,
					animateOut         : false,
					lazyLoad           : false,
					smartSpeed         : self.parseData( $data.smartSpeed, wpspLocalize.carouselSpeed ),
					rtl                : self.config.$isRTL,
					dots               : $data.dots,
					nav                : $data.nav,
					items              : $data.items,
					slideBy            : $data.slideby,
					center             : $data.center,
					loop               : $data.loop,
					margin             : $data.margin,
					autoplay           : $data.autoplay,
					autoplayTimeout    : $data.autoplayTimeout,
					autoplayHoverPause : true,
					navText            : [ '<span class="fa fa-chevron-left"><span>', '<span class="fa fa-chevron-right"></span>' ],
					responsive         : {
						0: {
							items : $data.itemsMobilePortrait
						},
						480: {
							items : $data.itemsMobileLandscape
						},
						768: {
							items : $data.itemsTablet
						},
						960: {
							items : $data.items
						}
					},
				} );

			} );

		},

		/**
		 * SliderPro
		 *
		 * @since 1.0.0
		 */
		sliderPro: function() {

			// Set main object to self
			var self = this;

			// Loop through each slider
			$( '.wpsp-slider' ).each( function() {

				// Declare vars
				var $slider = $( this ),
					$data   = $slider.data();

				// Lets show things that were hidden to prevent flash
				$( '.wpsp-slider-slide, .wpsp-slider-thumbnails' ).css( {
					'opacity': 1,
					'display': 'block'
				} );

				// Get height based on first items to prevent animation on initial load
				var $preloader               = $( '.wpsp-slider' ).prev( '.wpsp-slider-preloaderimg' ),
					$height                  = $preloader.length ? $preloader.outerHeight() : null,
					$heightAnimationDuration = self.parseData( $data.heightAnimationDuration, 500 );

				// Run slider
				$slider.sliderPro( {
					responsive              : true,
					width                   : '100%',
					height                  : $height,
					fade                    : self.parseData( $data.fade, 600 ),
					touchSwipe              : self.parseData( $data.touchSwipe, true ),
					fadeDuration            : self.parseData( $data.animationSpeed, 600 ),
					slideAnimationDuration  : self.parseData( $data.animationSpeed, 600 ),
					autoHeight              : self.parseData( $data.autoHeight, true ),
					heightAnimationDuration : $heightAnimationDuration,
					arrows                  : self.parseData( $data.arrows, true ),
					fadeArrows              : self.parseData( $data.fadeArrows, true ),
					autoplay                : self.parseData( $data.autoPlay, true ),
					autoplayDelay           : self.parseData( $data.autoPlayDelay, 5000 ),
					buttons                 : self.parseData( $data.buttons, true ),
					shuffle                 : self.parseData( $data.shuffle, false ),
					orientation             : self.parseData( $data.direction, 'horizontal' ),
					loop                    : self.parseData( $data.loop, false ),
					keyboard                : false,
					fullScreen              : self.parseData( $data.fullscreen, false ),
					slideDistance           : self.parseData( $data.slideDistance, 0 ),
					thumbnailsPosition      : 'bottom',
					thumbnailHeight         : self.parseData( $data.thumbnailHeight, 70 ),
					thumbnailWidth          : self.parseData( $data.thumbnailWidth, 70 ),
					thumbnailPointer        : self.parseData( $data.thumbnailPointer, false ),
					updateHash              : self.parseData( $data.updateHash, false ),
					thumbnailArrows         : false,
					fadeThumbnailArrows     : false,
					thumbnailTouchSwipe     : true,
					fadeCaption             : self.parseData( $data.fadeCaption, true ),
					captionFadeDuration     : 500,
					waitForLayers           : true,
					autoScaleLayers         : true,
					forceSize               : 'none',
					reachVideoAction        : 'playVideo',
					leaveVideoAction        : 'pauseVideo',
					endVideoAction          : 'nextSlide',
					fadeOutPreviousSlide    : false, // prevents flash on fast transitions
					init                    : function( event ) {
						$slider.prev( '.wpsp-slider-preloaderimg' ).hide();
						if ( $slider.parent( '.gallery-format-post-slider' ) && $( '.blog-masonry-grid' ).length ) {
							setTimeout( function() {
								$( '.blog-masonry-grid' ).isotope( 'layout' );
							}, $heightAnimationDuration + 1 );
						}
					},
					gotoSlideComplete       : function( event ) {
						if ( $slider.parent( '.gallery-format-post-slider' ) && $( '.blog-masonry-grid' ).length ) {
							$( '.blog-masonry-grid' ).isotope( 'layout' );
						}
					}

				} );

			} );

			// WooCommerce: Prevent clicking on Woo entry slider
			$( '.woo-product-entry-slider' ).click( function() {
				return false;
			} );

		   
		},

		/**
		 * Custom Selects
		 *
		 * @since 1.0.0
		 */
		customSelects: function() {

			// Custom selects based on wpspLocalize array
			$( wpspLocalize.customSelects ).customSelect( {
				customClass: 'theme-select'
			} );

			// WooCommerce
			if ( $.fn.select2 !== undefined ) {
				$( '#calc_shipping_country' ).select2();
			}

		},

		/**
		 * magnificPopup
		 *
		 * @since 1.0.0
		 */
		magnificPopup: function() {
			// Make sure equal heights function is defined
			if ( ! $.fn.magnificPopup ) {
				return;
			}

			// Setup content a link work with magnificPopup
		    $('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]').each(function(){
	        	if ($(this).parents('.gallery').length == 0) {
		            $(this).magnificPopup({
		               type: 'image',
		               removalDelay: 500,
		               mainClass: 'mfp-fade'
		            });
		        }
		    });

		    // Setup Woo Commerce product image and post gallery work with magnificPopup
			$('.wpsp-lightbox-group-item').magnificPopup({
					type: 'image',
					removalDelay: 300,
		            mainClass: 'mfp-fade',
					gallery:{
						enabled:true
					}
			});

			// Setup wp gallery work with magnificPopup
		    $('.gallery').each(function() {
		        $(this).magnificPopup({
		            delegate: 'a',
		            type: 'image',
		            removalDelay: 300,
		            mainClass: 'mfp-fade',
		            gallery: {
		            	enabled: true,
		            	navigateByImgClick: true
		            }
		        });
		    });

		    // Setup video work with magnificPopup
		    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
			});

		},

		/**
		 * Footer Reveal Display on Load
		 *
		 * @since 1.0.0
		 */
		footerRevealInit: function() {

			// Return if disabled
			if ( ! this.config.$hasFooterReveal ) {
				return;
			}

			// Declare main vars
			var $showFooter         = false,
				$windowHeight       = $( window ).height(),
				$footerRevealHeight = $( '.footer-reveal' ).outerHeight();

			// If window height is greater then the wrap height display footer
			if ( $windowHeight > $( '#wrap' ).height() ) {
				$showFooter = true;
			}

			// If window height is smaller then footer reveal display footer
			if ( $windowHeight < $footerRevealHeight ) {
				$showFooter = true;
			}

			// Display footer reveal since we can't properly perform the reveal
			if ( $showFooter ) {
				$( '.footer-reveal' ).show().toggleClass( 'footer-reveal footer-reveal-visible' );
			}

			// Add margin to the wrap div for the footer reveal
			else {
				
				$( '#wrap' ).css( {
					'margin-bottom': $footerRevealHeight
				} );

			}

		},

		/**
		 * Footer Reveal Display on Scroll
		 *
		 * @since 1.0.0
		 */
		footerRevealScrollShow: function() {
			if ( this.config.$hasFooterReveal ) {
				if ( this.config.$windowTop > $( '#main' ).offset().top ) {
					if ( ! $( '.footer-reveal' ).hasClass( 'wpsp-visible' ) ) {
						$( '.footer-reveal' ).show().addClass( 'wpsp-visible' );
					}
				} else {
					if ( $( '.footer-reveal' ).hasClass( 'wpsp-visible' ) ) {
						$( '.footer-reveal' ).removeClass( 'wpsp-visible' ).hide();
					}
				}
			}
		},

		/**
		 * Set min height on main container to prevent issue with extra space below footer
		 *
		 * @since 1.0.0
		 */
		fixedFooter: function() {

			// Return if disabled
			if ( ! this.config.$hasFixedFooter ) {
				return;
			}

			// Get main wrapper
			var $main = $( '#main' );

			// Make sure main exists
			if ( $main.length ) {

				// Set main vars
				var $mainHeight = $( '#main' ).outerHeight(),
					$htmlHeight = $( 'html' ).height();

				// Check for footerReveal and add min height
				var $minHeight = $mainHeight + ( this.config.$window.height() - $htmlHeight );

				// Add min height
				$main.css( 'min-height', $minHeight );

			}
		},

		/**
		 * Parses data to check if a value is defined in the data attribute and if not returns the fallback
		 *
		 * @since 1.0.0
		 */
		parseData: function( val, fallback ) {
			return ( typeof val !== 'undefined' ) ? val : fallback;
		},

		/**
		 * Local Scroll Offset
		 *
		 * @since 1.0.0
		 */
		parseLocalScrollOffset: function() {

			// Return custom offset
			if ( wpspLocalize.localScrollOffset ) {
				return wpspLocalize.localScrollOffset;
			}

			// Define return var
			var $offSet = 0;

			// Fixed header
			if ( ! this.config.$verticalHeaderActive
				&& this.config.$siteHeader
				&& this.config.$hasStickyHeader
				&& this.config.$siteHeaderHeight
				&& this.config.$siteHeader.hasClass( 'fixed-scroll' )
			) {


				// Return 0 for small screens if mobile fixed header is disabled
				if ( ! this.config.$hasStickyMobileHeader && this.config.$windowWidth <= wpspLocalize.stickyHeaderBreakPoint ) {
					$offSet = 0;
				}

				// Return header height
				else {

					// Shrink header
					if ( this.config.$siteHeader.hasClass( 'wpsp-shrink-sticky-header' ) ) {
						$offSet = wpspLocalize.shrinkHeaderHeight;
					}

					// Standard header
					else {
						$offSet = this.config.$siteHeaderHeight;
					}

				}

			}

			// Fixed Nav
			if ( $( '#site-navigation-wrap' ).length && $( '#site-navigation-wrap' ).hasClass( 'fixed-nav' ) ) {
				if ( this.config.$windowWidth >= wpspLocalize.stickyHeaderBreakPoint ) {
					$offSet = parseInt( $offSet ) + parseInt( $( '#site-navigation-wrap' ).outerHeight() );
				}
			}

			// Add sticky topbar height offset
			if ( this.config.$hasStickyTopBar && this.config.$stickyTopBarHeight ) {
				$offSet = parseInt( $offSet ) + parseInt( this.config.$stickyTopBarHeight );
			}

			// Add wp toolbar
			if ( $( '#wpadminbar' ).length ) {
				$offSet = parseInt( $offSet ) + parseInt( $( '#wpadminbar' ).outerHeight() );
			}

			// Return offset
			return $offSet;

		},

	} //wpspCustom

	wpspCustom.init();
	

} ) ( jQuery );	