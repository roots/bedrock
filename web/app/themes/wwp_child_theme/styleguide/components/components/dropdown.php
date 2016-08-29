<!--components/components/dropdown.php-->

<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Dropdown button
  <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
    <li role="presentation"><a role="menuitem" href="#">Action</a></li>
    <li role="presentation"><a role="menuitem" href="#">Another action</a></li>
    <li role="presentation"><a class="dropdown-item" href="#">Something else here</a></li>
    <li role="presentation" class="divider"></li>
    <li role="presentation"><a role="menuitem" href="#">About Us</a></li>
  </ul>
</div>


<script>
	(function($){
  		$('.dropdown-toggle').on('click', function(e){
  		  $(this).parent().toggleClass('open').siblings().removeClass('open');
  		});
  		$(document).on('mouseup', function(e){
  		  if (!$(e.target).hasClass('dropdown-toggle')) {
  		    $('.dropdown-menu').parent().removeClass('open');
  		  }
  		});
	})(jQuery);
</script>