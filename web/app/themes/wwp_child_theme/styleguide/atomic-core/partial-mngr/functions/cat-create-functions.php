<?php





function createPageIncludeFile($dirName)
{
  
	fopen("../categories/$dirName/$dirName.php", 'x+') or die("can't open file");
}



function createScssCatDirAndFile($dirName)
{
  
  $config = getConfig();
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];
  
	mkdir("../../$cssDir/$dirName");
	$fileHandle = fopen("../../$cssDir/$dirName/_$dirName.$cssExt", 'x+') or die("can't open file");
}



function createStringForMainScssFile($dirName)
{
  
  $config = getConfig();
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];
  
	$includeString ='@import "'.$dirName.'/_'.$dirName.'";';
	
	$includeString = "\n$includeString\n";
	
	$fileHandle = fopen('../../'.$cssDir.'/main.'.$cssExt.'', 'a') or die("can't open file");
	fwrite($fileHandle, $includeString);
	
	file_put_contents('../../'.$cssDir.'/main.'.$cssExt.'', implode(PHP_EOL, file('../../'.$cssDir.'/main.'.$cssExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}



function createAtomicCategoryDir($dirName )
{
    mkdir("../categories/$dirName");
}


function createCompCatDir($dirName)
{
    
	mkdir("../../components/$dirName");
}







function createPageTemplate($dirName)
{

	$includeString = 
	'
<?php include ("head.php");?>
	<body class="'.$dirName.'">
	
	
	<div class="atoms-container">
			<?php include ("sidebar.php");?>
			
			
			<div class="atoms-main">
					<h1 id="'.$dirName.'" class="atomic-h1">'.$dirName.'</h1>
	
	
							<?php include ("categories/'.$dirName.'/'.$dirName.'.php");?>
              
	
	
			</div>
	</div>
	<div class="aa_js-actionDrawer aa_actionDrawer">
	<div class="aa_actionDrawer__wrap">
	    <div class="aa_js-actionClose  aa_actionDrawer__close"><i class="fa fa-times fa-3x"></i></div>
	    <div id="js_actionDrawer__content" class="actionDrawer__content"></div>
	<div/>
  </div>
	<?php include ("footer.php");?>
'
	;
	
	$includeString = "\n$includeString\n";
	
	$fileHandle = fopen('../'.$dirName.'.php', 'x+') or die("can't open file");
	fwrite($fileHandle, $includeString);
	
	file_put_contents('../'.$dirName.'.php', implode(PHP_EOL, file('../'.$dirName.'.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
	
	
}


function createSidebarIncludeAndFile($dirName)
{
	$config = getConfig();
    $compExt = $config['compExt'];
	
	$includeString = 
'<li class="aa_dir <?php if ($current_page == "'.$dirName.'.php"){ echo "active "; }?>">
		<div class="aa_dir__dirNameGroup">
			<i class="aa_dir__dirNameGroup__icon  fa fa-folder-o"></i>
			<a class="aa_dir__dirNameGroup__name" href="atomic-core/'.$dirName.'.php">'.$dirName.'</a>
		</div>
		<ul class="aa_fileSection">
      <li class="aa_addFileItem">
        <a class="aa_addFile aa_js-actionOpen aa_actionBtn" href="atomic-core/categories/'.$dirName.'/form-'.$dirName.'.php"><span class="fa fa-plus"></span> Add Component</a>
      </li>
			<?php
				$orig = "../components/'.$dirName.'";
				if ($dir = opendir($orig)) {
				while ($file = readdir($dir)) {
				$ok = "true";	
				$filename = $file;
				$filename = basename($filename, ".'.$compExt.'");
				if ($file == "."){
				$ok = "false";
				}
				else if ($file == ".."){
				$ok = "false";	
				}
				if ($ok == "true"){
					
				$filename = str_replace(".'.$compExt.'", "", $filename );

				echo "<li class=\'aa_fileSection__file\'><a class=\'aa_js-actionOpen aa_actionBtn fa fa-pencil-square-o\' href=\'atomic-core/categories/'.$dirName.'/form-$filename.php\'></a><a href=\'atomic-core/'.$dirName.'.php#$filename\'>$filename</a></li>";
				}
				}
				closedir($dir);
				}
			?>
		</ul>
</li>'		
;

	$includeString = "\n$includeString\n";

	
	$fileHandle = fopen('../categories/'.$dirName.'/navItem-'.$dirName.'.php', 'a') or die("can't open file");
	fwrite($fileHandle, $includeString);
	
  
	
}



function writeNavItem($dirName)
{
	
  
  
	//create @import string
	$importString = "<?php include ('$dirName/navItem-$dirName.php');?>";
	$importString = "\n$importString\n";
	
	//open parent scss file and write @import string to it
	$fileHandle = fopen('../categories/atomic-nav.php', 'a') or die("can't open file");
	fwrite($fileHandle, $importString);
    fclose($fileHandle);   
	
	//remove any extra line breaks from file
	file_put_contents('../categories/atomic-nav.php', implode(PHP_EOL, file('../categories/atomic-nav.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));       
}







function createAjaxIncludeAndFile($dirName)
{
	
	$includeString = 
'<div class="aa_fileFormGroup">
    <form id="form-create-file" class="aa_fileForm " action="/atomic-core/' .$dirName.'.php" method="post">
     
      <div class="inputGroup">
        <label class="aa_label">What\'s your component\'s name?</label>
        <input type="text" class="form-control" name="fileCreateName">
      </div>
        <label class="aa_label">Component description.</label>
        <textarea class="form-control" name="compNotes"></textarea>
        <label class="aa_label">Contextual background color.</label>
        <div class="bgColorWrap">
          <input class="bgColor" type="text" name="bgColor" value="" />
        </div>
        <button class="aa_btn aa_btn-pos" type="submit" >Add</button>
      <input type="hidden" name="compDir" value="'.$dirName.'"/>
      <input type="hidden" name="create" value="create"/>
    </form>
</div>'		
;

	$includeString = "\n$includeString\n";
  
  	
	
	$fileHandle = fopen('../categories/'.$dirName.'/form-'.$dirName.'.php', 'x+') or die("can't open file");
	fwrite($fileHandle, $includeString);
	
	file_put_contents('../categories/'.$dirName.'/form-'.$dirName.'.php', implode(PHP_EOL, file('../categories/'.$dirName.'/form-'.$dirName.'.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
	
}





?>