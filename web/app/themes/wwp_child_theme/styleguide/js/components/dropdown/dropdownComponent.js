(function ($,ns) {

	var dropdownComponent = function ($dropdownWrap) {
		this.$wrap = $dropdownWrap || $('.dropdown-wrap');
		this.init();
	};

	dropdownComponent.prototype = {
		init: function () {

			this.$wrap('.dropdown-toggle').on('click', function(e){
				$(this).parent().toggleClass('open').siblings().removeClass('open');
			});
			$(document).on('mouseup', function(e){
				if (!$(e.target).hasClass('dropdown-toggle')) {
					$('.dropdown-menu').parent().removeClass('open');
				}
			});


		}
	};




})(jQuery, window.wonderwp);
