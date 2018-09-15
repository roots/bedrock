(function($){
	$(document).ready(function(){
		$(".ult-carousel-wrapper").each(function(){
			var $this = $(this);
			if($this.hasClass("ult_full_width")){
				$this.css('left',0);
				$this.css('right',0);
				var rtl = $this.attr('data-rtl');
				var w = $("html").outerWidth();
				var al = 0;
				var bl = $this.offset().left;
				var xl = Math.abs(al-bl);
				var left = xl;
				if(rtl === 'true' || rtl === true)
					$this.css({"position":"relative","right":"-"+left+"px","width":w+"px"});
				else
					$this.css({"position":"relative","left":"-"+left+"px","width":w+"px"});
			}
		});
		$('.ult-carousel-wrapper').each(function(i,carousel) {
			var gutter = $(carousel).data('gutter');
			var id = $(carousel).attr('id');
			if(gutter != '')
			{
				var css = '<style>#'+id+' .slick-slide { margin:0 '+gutter+'px; } </style>';
				$('head').append(css);
			}
		});

		$(window).resize(function(){
			$(".ult-carousel-wrapper").each(function(){
				var $this = $(this);
				if($this.hasClass("ult_full_width")){
					var rtl = $this.attr('data-rtl');
					$this.removeAttr("style");
					var w = $("html").outerWidth();
					var al = 0;
					var bl = $this.offset().left;
					var xl = Math.abs(al-bl);
					var left = xl;
					if(rtl === 'true' || rtl === true)
						$this.css({"position":"relative","right":"-"+left+"px","width":w+"px"});
					else
						$this.css({"position":"relative","left":"-"+left+"px","width":w+"px"});
				}
			});
		});
	});
	$(window).load(function(){
		$(".ult-carousel-wrapper").each(function(){
			var $this = $(this);
			if($this.hasClass("ult_full_width")){
				$this.css('left',0);
				$this.css('right',0);
				var al = 0;
				var bl = $this.offset().left;
				var xl = Math.abs(al-bl);
				var rtl = $this.attr('data-rtl');
				var w = $("html").outerWidth();
				var left = xl;
				if(rtl === 'true' || rtl === true)
					$this.css({"position":"relative","right":"-"+left+"px","width":w+"px"});
				else
					$this.css({"position":"relative","left":"-"+left+"px","width":w+"px"});
			}
		});
	});
})(jQuery);