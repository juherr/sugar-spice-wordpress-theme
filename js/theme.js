(function ($) {
	'use strict';

	$(function () {
		$('.widget-title').each(function () {
			var $title = $(this);
			$title.html($title.html().replace(/(\S+)\s*$/, '<em>$1</em>'));
		});

		$('#reply-title').addClass('section-title').wrapInner('<span></span>');

		if ( $.fn.flexslider && $('.flexslider').length ) {
			$('.flexslider').flexslider({
				directionNav: false,
				pauseOnAction: false
			});

			$('.flex-control-nav').each(function () {
				var $nav = $(this);
				$nav.css('margin-left', '-' + ($nav.width() / 2) + 'px');
			});
		}

		if ( $.fn.tinyNav && $('#nav').length ) {
			$('#nav').tinyNav({
				header: sugarspiceTheme.menuLabel || 'Menu'
			});
		}
	});
})(jQuery);
