jQuery(document).ready(function () {
	jQuery("html").removeClass("no-js");
	jQuery(window).on("scroll", function () {
		if (window.pageYOffset >= 100) {
			jQuery("body").addClass("page-scrolling");
		} else {
			jQuery("body").removeClass("page-scrolling");
		}
	});
});

/**
 * File skip-link-focus-fix.js
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://github.com/Automattic/_s/pull/136
 *
 * @package Analytica
 */

(function () {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf("webkit") > -1,
		is_opera = navigator.userAgent.toLowerCase().indexOf("opera") > -1,
		is_ie = navigator.userAgent.toLowerCase().indexOf("msie") > -1;

	if (
		(is_webkit || is_opera || is_ie) &&
		document.getElementById &&
		window.addEventListener
	) {
		window.addEventListener(
			"hashchange",
			function () {
				var id = location.hash.substring(1),
					element;

				if (!/^[A-z0-9_-]+$/.test(id)) {
					return;
				}

				element = document.getElementById(id);

				if (element) {
					if (
						!/^(?:a|select|input|button|textarea)$/i.test(
							element.tagName
						)
					) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			},
			false
		);
	}
})();
