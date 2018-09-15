<?php
if( !defined( 'ABSPATH') ) exit();

$operations = new RevSliderOperations();

$sliderID = self::getGetVar("id");

if(empty($sliderID))
	RevSliderFunctions::throwError("Slider ID not found"); 

$slider = new RevSlider();
$slider->initByID($sliderID);
$sliderParams = $slider->getParams();

$arrSliders = $slider->getArrSlidersShort($sliderID);
$selectSliders = RevSliderFunctions::getHTMLSelect($arrSliders,"","id='selectSliders'",true);

$numSliders = count($arrSliders);

//set iframe parameters	
$width = $sliderParams["width"];
$height = $sliderParams["height"];

$iframeWidth = $width+60;
$iframeHeight = $height+50;

$iframeStyle = "width:".$iframeWidth."px;height:".$iframeHeight."px;";

if($slider->isSlidesFromPosts()){
	$arrSlides = $slider->getSlidesFromPosts(false);
}elseif($slider->isSlidesFromStream()){
	$arrSlides = $slider->getSlidesFromStream(false);
}else{
	$arrSlides = $slider->getSlides(false);
}

$numSlides = count($arrSlides);

$linksSliderSettings = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER,'id='.$sliderID);

//treat in case of slides from gallery
if($slider->isSlidesFromPosts() == false){
	//removed in 5.0
}else{	//slides from posts
	//removed in 5.1.7
}
?>