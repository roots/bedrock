<?php

if( !defined( 'ABSPATH') ) exit();

$urlIconDelete = RS_PLUGIN_URL."admin/assets/images/icon-trash.png";
$urlIconEdit = RS_PLUGIN_URL."admin/assets/images/icon-edit.png";
$urlIconPreview = RS_PLUGIN_URL."admin/assets/images/preview.png";

$textDelete = __("Delete Slide",'revslider');
$textEdit = __("Edit Slide",'revslider');
$textPreview = __("Preview Slide",'revslider');

$htmlBefore = "";
$htmlBefore .= "<li class='item_operation operation_delete'><a data-operation='delete' href='javascript:void(0)'>"."\n";
$htmlBefore .= "<img src='".$urlIconDelete."'/> ".$textDelete."\n";				
$htmlBefore .= "</a></li>"."\n";

$htmlBefore .= "<li class='item_operation operation_edit'><a data-operation='edit' href='javascript:void(0)'>"."\n";
$htmlBefore .= "<img src='".$urlIconEdit."'/> ".$textEdit."\n";				
$htmlBefore .= "</a></li>"."\n";

$htmlBefore .= "<li class='item_operation operation_preview'><a data-operation='preview' href='javascript:void(0)'>"."\n";
$htmlBefore .= "<img src='".$urlIconPreview."'/> ".$textPreview."\n";				
$htmlBefore .= "</a></li>"."\n";

$htmlBefore .= "<li class='item_operation operation_sap'>"."\n";
$htmlBefore .= "<div class='float_menu_sap'></div>"."\n";				
$htmlBefore .= "</a></li>"."\n";

$langFloatMenu = RevSliderWpml::getLangsWithFlagsHtmlList("id='slides_langs_float' class='slides_langs_float'",$htmlBefore);

?>
<div id="langs_float_wrapper" class="langs_float_wrapper" style="display:none">
<?php echo $langFloatMenu; ?>
</div>

<div id="rev_lang_list">
	<div class="slide_langs_selector editor_buttons_wrapper  postbox unite-postbox" style="margin-bottom:20px; max-width:100% !important; min-width:1040px !important;">
		<div class="slide-main-settings-form" style="padding:15px;">
			
			<label style="display:inline-block; margin-right:15px;"><?php _e("Choose slide language",'revslider'); ?>:</label>
			
			<ul class="list_slide_icons" style="display:inline-block; vertical-align: middle; margin-bottom:0px;">
				<?php
				$langSlide = $slide->getParentSlide(); //go to parent slide if nessecary here
				$arrSlideLangCodes = $langSlide->getArrChildLangCodes();
				$parent_id = $langSlide->getID();
				
				$addItemStyle = "";
				if(RevSliderWpml::isAllLangsInArray($arrSlideLangCodes))
					$addItemStyle = "style='display:none'";
					
				foreach($arrChildLangs as $arrLang){
					$isParent = RevSliderFunctions::boolToStr($arrLang["isparent"]);
					$childSlideID = $arrLang["slideid"];
					$lang = $arrLang["lang"];
					$urlFlag = RevSliderWpml::getFlagUrl($lang);
					$langTitle = RevSliderWpml::getLangTitle($lang);
					$class = "";
					$urlEditSlide = self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=$childSlideID");
					if($childSlideID == $slideID){
						$class = "lang-selected";
						$urlEditSlide = "javascript:void(0)";
					}
					if($lang == 'all'){
						$urlFlag = RS_PLUGIN_URL.'admin/assets/images/icon-all.png';
					}
					?>
					<li class="<?php echo $class; ?>">
						<img id="icon_lang_<?php echo $childSlideID; ?>" class="icon_slide_lang" src="<?php echo $urlFlag; ?>" title="<?php echo $langTitle; ?>" data-slideid="<?php echo $childSlideID; ?>" data-lang="<?php echo $lang; ?>" data-isparent="<?php echo $isParent; ?>">
						<div class="icon_lang_loader loader_round" style="display:none"></div>
					</li>
					<?php
				}
				
				?>
				<li>
					<div id="icon_add_lang_<?php echo $slideID; ?>" class="icon_slide_lang_add" data-operation="add" data-slideid="<?php echo $slideID; ?>" data-origid="<?php echo $parent_id; ?>" <?php echo $addItemStyle; ?>></div>
					<div class="icon_lang_loader loader_round" style="display:none"></div>
				</li>
			</ul>
		</div>
	</div>
</div>
