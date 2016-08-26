<?php include ("head.php");?>
<body class="atoms">


<div class="grid-row atoms-container">
	<?php include ("sidebar.php");?>
	

	
	<div class="atoms-main">

	
	<?php /*?><?php echo ROOT_PATH; ?><?php */?>
		<!--<div class="docBlock">
			<h1 class="docBlock-heading">Welcome!</h1>
			<p>Atomic Docs is made for <a href="https://www.previousnext.com.au/blog/style-guide-driven-development-new-web-development">styleguide driven development</a>.</p>
			<p>Requirements: A local PHP enviornment. And a CSS preprocessor.<p> 
			
			<ol class="docBlock-ul">
				<li>Set up your CSS preprocessor of choice. As expected we will be processing from our SCSS directory to the CSS directory.</li>
				<li>In the lower left hand corner, open the "Manage Categories" form. In the create category field we will create a new component category. In a nod to <a href="http://atomicdesign.bradfrost.com/"> Brad Frost</a>, I'll call this one "molecules".
					<img class="docBlock-img" src="atomic-core/img/doc1.png" />
				</li>
				<li>Click on the newly created molecules link in the sidebar to go to the molecules page. In the form below the molecules link let's create a new component called "calloutBox".
					<img class="docBlock-img" src="atomic-core/img/doc2.png" />
				</li>
				<li>So next we'll create the HTML for the calloutBox component. In the project directory you'll notice a folder named "compontents". Open that and you'll find the folder molecules. This is the directory that all of the HTML component files you create under the molecules category will be located. Let's open the file "calloutBox.php" and put some HTML code there.
                    <img class="docBlock-img" src="atomic-core/img/doc3.png" />
				</li>
				<li>Back in our projects directory open up the SCSS folder. You will see the folder molecules and within molecules is the the newly created _calloutBox.scss file. This of course is where we'll put our styles for the calloutBox component. As a side note, atomic-docs handles wiring up all of the scss "@import" strings. Even if I'm not creating a style guide this feature is sooo time saving.
                   <img class="docBlock-img" src="atomic-core/img/doc4.png" />
				</li>
				<li>Now back to our project in the browser. Click on the molecules link in the sidebar and you'll see our newly created component.
                    <img class="docBlock-img docBlock-img__big" src="atomic-core/img/doc5.png" />
				</li>
				<li>And that's it!</li>
			</ol>
		</div>-->

	</div>
</div>
<div class="aa_js-actionDrawer aa_actionDrawer">
  <div class="aa_actionDrawer__wrap">
	  <div class="aa_js-actionClose aa_actionDrawer__close"><i class="fa fa-times fa-3x"></i></div>
	  <div id="js_actionDrawer__content" class="actionDrawer__content"></div>
  </div>
</div>
<?php include ("footer.php");?>