<?php




function deleteCatPageFile($catName)
{

	unlink('../'.$catName.'.php');
}

function deleteAtomicCatDir($catName) { 
		
   $catName = '../categories/'.$catName;
	
   if (is_dir($catName)) { 
     $objects = scandir($catName); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($catName."/".$object) == "dir") deleteCompDir($catName."/".$object); else unlink($catName."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($catName); 
   } 
} 

function deleteAtomicNavIncludeString($dirName)
{
	
   $includeString = "<?php include ('$dirName/navItem-$dirName.php');?>";		


	//Place contents of file into variable
	$contents = file_get_contents('../categories/atomic-nav.php');
	
	$contents = str_replace($includeString, "", $contents);
	$contents = file_put_contents('../categories/atomic-nav.php', $contents);

	file_put_contents('../categories/atomic-nav.php', implode(PHP_EOL, file('../categories/atomic-nav.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))); 
}



function deleteCompDir($catName) { 
		
   $catName = '../../components/'.$catName;
	
   if (is_dir($catName)) { 
     $objects = scandir($catName); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($catName."/".$object) == "dir") deleteCompDir($catName."/".$object); else unlink($catName."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($catName); 
   } 
} 










function deleteCatScssImportString($catName)
{

    $config = getConfig();
    $cssDir = $config['preCssDir'];
    $cssExt = $config['preCssExt'];

	$importString ='@import "'.$catName.'/_'.$catName.'";';
		
	//Place contents of file into variable
	$contents = file_get_contents('../../'.$cssDir.'/main.'.$cssExt.'');
	
	$contents = str_replace($importString, "", $contents);
	$contents = file_put_contents('../../'.$cssDir.'/main.'.$cssExt.'', $contents);
}



function deleteScssDir($catName) {

    $config = getConfig();
    $cssDir = $config['preCssDir'];
    $cssExt = $config['preCssExt'];


	   $catName = '../../'.$cssDir.'/'.$catName;
	
	   if (is_dir($catName)) { 
	     $objects = scandir($catName); 
	     foreach ($objects as $object) { 
	       if ($object != "." && $object != "..") { 
	         if (filetype($catName."/".$object) == "dir") deleteCompDir($catName."/".$object); else unlink($catName."/".$object); 
	       } 
	     } 
	     reset($objects); 
	     rmdir($catName); 
	   }
} 





?>