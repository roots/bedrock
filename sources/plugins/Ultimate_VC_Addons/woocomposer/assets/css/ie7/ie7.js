/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'WooComposer\'">' + entity + '</span>' + html;
	}
	var icons = {
		'wooicon-uniE612': '&#xe612;',
		'wooicon-paperplane': '&#xe60f;',
		'wooicon-reply': '&#xe615;',
		'wooicon-reply-all': '&#xe616;',
		'wooicon-forward': '&#xe603;',
		'wooicon-export': '&#xe610;',
		'wooicon-heart': '&#xe617;',
		'wooicon-heart2': '&#xe618;',
		'wooicon-star': '&#xe600;',
		'wooicon-star2': '&#xe601;',
		'wooicon-thumbsup': '&#xe602;',
		'wooicon-thumbsdown': '&#xe60c;',
		'wooicon-flag': '&#xe60d;',
		'wooicon-tag': '&#xe60e;',
		'wooicon-bag': '&#xe604;',
		'wooicon-cart4': '&#xe605;',
		'wooicon-cross': '&#xe606;',
		'wooicon-plus3': '&#xe607;',
		'wooicon-cross2': '&#xe608;',
		'wooicon-plus22': '&#xe609;',
		'wooicon-cross3': '&#xe60a;',
		'wooicon-plus32': '&#xe60b;',
		'wooicon-cycle': '&#xe611;',
		'wooicon-play': '&#xe613;',
		'wooicon-pause': '&#xe614;',
		'wooicon-arrow-left4': '&#xe619;',
		'wooicon-arrow-right5': '&#xe61a;',
		'wooicon-arrow-left5': '&#xe61b;',
		'wooicon-arrow-right6': '&#xe61c;',
		'wooicon-arrow-left6': '&#xe61d;',
		'wooicon-arrow-right7': '&#xe61e;',
		'wooicon-arrow-left7': '&#xe61f;',
		'wooicon-arrow-right8': '&#xe620;',
		'wooicon-arrow-left8': '&#xe621;',
		'wooicon-arrow-right9': '&#xe622;',
		'wooicon-arrow-left9': '&#xe623;',
		'wooicon-arrow-right10': '&#xe624;',
		'wooicon-arrow-left10': '&#xe625;',
		'wooicon-uniE626': '&#xe626;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/wooicon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
