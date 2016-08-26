<?php 	

	$current_page = basename($_SERVER['PHP_SELF']);
   
?>

    



<div class="atoms-side_show-small ">
	<span class="toggle-line"></span>
	<span class="toggle-line"></span>
	<span class="toggle-line"></span>
</div>

<div class="atoms-side_show ">
	<span class="js-showSide fa fa-arrow-right"></span>
</div>
<aside class="atoms-side">
<div class="atoms-overflow">

	<div class="atoms-side_hide">
		<span class="js-hideSide fa fa-arrow-left"></span>
		<span class="js-hideTitle fa fa-header"></span>
        </span><span class="js-hideNotes fa fa-paragraph"></span>
		</span><span class="js-hideCode fa fa-code"></span>
    </div>
	<!-- <span class="atoms-side_hide">Hide Sidebar</span> -->

	<nav>
		<ul class="atoms-nav">
			<?php include ("categories/atomic-nav.php");?>
      <li class="catAdd"><a class="aa_js-actionOpen aa_actionBtn" href="atomic-core/categories/_catActions.php"><span class="fa fa-plus"></span> Add / Delete Category</a></li>
		</ul>
		 
	</nav>


</div>

            <div class="cat-form js-showContent"></div>
            
          
</aside>




