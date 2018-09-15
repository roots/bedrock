<?php
if( !defined('ABSPATH') ) exit();

//get taxonomies with cats
$postTypesWithCats = RevSliderOperations::getPostTypesWithCatsForClient();		
$jsonTaxWithCats = RevSliderFunctions::jsonEncodeForClientSide($postTypesWithCats);

//check existing slider data:
$sliderID = self::getGetVar('id');

$arrFieldsParams = array();

$uslider = new RevSlider();

if(!empty($sliderID)){
	$slider = new RevSlider();
	$slider->initByID($sliderID);
	
	//get setting fields
	$settingsFields = $slider->getSettingsFields();
	$arrFieldsMain = $settingsFields['main'];
	$arrFieldsParams = $settingsFields['params'];		
	
	$linksEditSlides = self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,'id=new&slider='.intval($sliderID));
	
	require self::getPathTemplate('edit-slider');
}else{
	require self::getPathTemplate('create-slider');		
}

?>