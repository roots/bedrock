<?php
/**
 * Plugin Update Class For Essential Grid
 * Enables automatic updates on the Plugin
 *
 * @package Essential_Grid_Plugin_Update
 * @author  ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 * @since 1.1.0
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Plugin_Update {
	
	private $version;
	
	public function __construct($version) {
		
		$this->set_version($version);
		
	}
	
	
	/**
	 * update the version
	 */
	public function update_version($new_version){
	
		update_option("tp_eg_grids_version", $new_version);
		
	}
	
	
	/**
	 * set the version in class
	 */
	public function set_version($new_version){
	
		$this->version = $new_version;
		
	}
	
	
	/**
	 * update routine, do updates depending on what version we currently are
	 */
	public function do_update_process(){
	
		if(version_compare($this->version, '1', '<=')){
			$this->update_to_110();
		}
		
		if(version_compare($this->version, '2.0', '<')){
			$this->update_to_20();
		}
		
		if(version_compare($this->version, '2.0.1', '<')){
			$this->update_to_201();
		}
		
		if(version_compare($this->version, '2.1.0', '<')){
			$this->update_to_210();
		}
		
		do_action('essgrid_do_update_process', $this->version);
	}
	
	
	/**
	 * update to 1.1.0
	 * @since: 1.1.0
	 * @does: adds navigation skins to support dropdowns
	 */
	public function update_to_110(){
		
		//update navigation skins to support dropdowns
		$nav = new Essential_Grid_Navigation();
		
		$navigation_skins = array(
			array('handle' => 'flat-light','css' => '/* FLAT LIGHT SKIN DROP DOWN 1.1.0 */
.flat-light .esg-filterbutton 								{ 	color:#000;color:rgba(0,0,0,0.5);}

.flat-light	.esg-selected-filterbutton						{	background:#fff; padding:10px 20px 10px 30px; color:#000; border-radius: 4px;font-weight:700;}

.flat-light .esg-cartbutton,
.flat-light .esg-cartbutton a,
.flat-light .esg-cartbutton a:visited,
.flat-light .esg-cartbutton a:hover,
.flat-light .esg-cartbutton i,
.flat-light .esg-cartbutton i.before								{	font-weight:700; color:#000; }
.flat-light .esg-selected-filterbutton .eg-icon-down-open	{	 margin-left:5px;font-size:12px; line-height: 20px; vertical-align: top;}

.flat-light .esg-selected-filterbutton:hover .eg-icon-down-open,
.flat-light .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open	{	 color:rgba(0,0,0,1); }

.flat-light .esg-dropdown-wrapper							{	border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
.flat-light .esg-dropdown-wrapper .esg-filterbutton			{	line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:700; text-align: left}
.flat-light .esg-dropdown-wrapper .esg-filter-checked		{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important;}
.flat-light .esg-dropdown-wrapper .esg-filter-checked span	{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'flat-dark','css' => '/* FLAT DARK SKIN DROP DOWN 1.1.0 */
.flat-dark .esg-filterbutton 								{ 	color:#fff !important}

.flat-dark .esg-selected-filterbutton						{	background: #3A3A3A; background: rgba(0, 0, 0, 0.2); padding:10px 20px 10px 30px; color:#fff; border-radius: 4px;font-weight:600; }

.flat-dark .esg-cartbutton,
.flat-dark .esg-cartbutton a,
.flat-dark .esg-cartbutton a:visited,
.flat-dark .esg-cartbutton a:hover,
.flat-dark .esg-cartbutton i,
.flat-dark .esg-cartbutton i.before						{	font-weight:600; color:#fff; }
.flat-dark .esg-selected-filterbutton .eg-icon-down-open	{	margin-left:5px;font-size:12px; line-height: 20px; vertical-align: top;}

.flat-dark .esg-selected-filterbutton:hover .eg-icon-down-open,
.flat-dark .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open		{	 color:rgba(255,255,255,1); }
.flat-dark .esg-cartbutton:hover,
.flat-dark .esg-selected-filterbutton:hover, 
.flat-dark .esg-selected-filterbutton.hoveredfilter		{	background: rgba(0, 0, 0, 0.5); }

.flat-dark .esg-dropdown-wrapper							{	background:#222; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
.flat-dark .esg-dropdown-wrapper .esg-filterbutton			{	background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:600; text-align: left; color:#fff; color:rgba(255,255,255,0.5) !important;}
.flat-dark .esg-dropdown-wrapper .esg-filterbutton:hover,
.flat-dark .esg-dropdown-wrapper .esg-filterbutton.selected	{	background:transparent !important; color:#fff; color:rgba(255,255,255,1) !important;}
.flat-dark .esg-dropdown-wrapper .esg-filter-checked		{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important;}
.flat-dark .esg-dropdown-wrapper .esg-filter-checked span	{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'minimal-dark','css' => '/* MINIMAL DARK SKIN DROP DOWN 1.1.0 */
.minimal-dark .esg-filterbutton 								{ 	color:#fff !important}

.minimal-dark .esg-selected-filterbutton						{	background: transparent; border: 1px solid rgba(255, 255, 255, 0.1);background: rgba(0, 0, 0, 0); padding:10px 20px 10px 30px; color:#fff; border-radius: 4px;font-weight:600;}

.minimal-dark .esg-cartbutton									{	border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius:5px !important; -moz-border-radius:5px !important;-webkit-border-radius:5px !important;}
.minimal-dark .esg-cartbutton,
.minimal-dark .esg-cartbutton a,
.minimal-dark .esg-cartbutton a:visited,
.minimal-dark .esg-cartbutton a:hover,
.minimal-dark .esg-cartbutton i,
.minimal-dark .esg-cartbutton i.before						{	font-weight:600; color:#fff; }
.minimal-dark .esg-selected-filterbutton .eg-icon-down-open	{	margin-left:5px;font-size:12px; line-height: 20px; vertical-align: top; color:#fff;}

.minimal-dark .esg-cartbutton:hover,
.minimal-dark .esg-selected-filterbutton:hover, 
.minimal-dark .esg-selected-filterbutton.hoveredfilter		{	border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.1); }

.minimal-dark .esg-dropdown-wrapper								{	background:#333; background:rgba(0,0,0,0.95);border: 1px solid rgba(255, 255, 255, 0.1);border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
.minimal-dark .esg-dropdown-wrapper .esg-filterbutton			{	border:none !important; box-shadow:none !important; background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:600; text-align: left; color:#fff; color:rgba(255,255,255,0.5) !important;}
.minimal-dark .esg-dropdown-wrapper .esg-filterbutton:hover,
.minimal-dark .esg-dropdown-wrapper .esg-filterbutton.selected	{	background:transparent !important; color:#fff; color:rgba(255,255,255,1) !important; }
.minimal-dark .esg-dropdown-wrapper .esg-filter-checked			{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important; border: 1px solid rgba(255, 255, 255, 0.2)}
.minimal-dark .esg-dropdown-wrapper .esg-filter-checked span	{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'minimal-light','css' => '/* MINIMAL LIGHT SKIN DROP DOWN 1.1.0 */
.minimal-light .esg-filterbutton 								{ 	color:#999 !important}

.minimal-light .esg-selected-filterbutton						{	 border: 1px solid #E5E5E5;background: #fff; padding:10px 20px 10px 30px; color:#999; border-radius: 4px;font-weight:700;  }

.minimal-light .esg-selected-filterbutton .eg-icon-down-open	{	margin-left:5px;font-size:12px; line-height: 20px; vertical-align: top; color:#999;}

.minimal-light .esg-filter-wrapper .esg-filterbutton span i 			{ color: #fff !important;  }
.minimal-light .esg-filter-wrapper .esg-filterbutton:hover span, 
.minimal-light .esg-filter-wrapper .esg-filterbutton.selected span		{ color: #000 !important;  }
.minimal-light .esg-filter-wrapper .esg-filterbutton:hover span i, 
.minimal-light .esg-filter-wrapper .esg-filterbutton.selected span i		{ color: #fff !important;  }

.minimal-light .esg-selected-filterbutton:hover .eg-icon-down-open,
.minimal-light .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open		{	 color:rgba(0,0,0,1) !important; }
.minimal-light .esg-cartbutton:hover, 							
.minimal-light .esg-selected-filterbutton:hover, 
.minimal-light .esg-selected-filterbutton.hoveredfilter		{	border-color: #bbb; color: #333; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13); }

.minimal-light .esg-dropdown-wrapper							{	background:#fff; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; border: 1px solid #bbb; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);}
.minimal-light .esg-dropdown-wrapper .esg-filterbutton			{	border:none !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:700; text-align: left; color:#999; }
.minimal-light .esg-dropdown-wrapper .esg-filterbutton:hover,
.minimal-light .esg-dropdown-wrapper .esg-filterbutton.selected	{	background:transparent !important; color:#000 !important; box-shadow: none !important}
.minimal-light .esg-dropdown-wrapper .esg-filter-checked		{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important;}
.minimal-light .esg-dropdown-wrapper .esg-filter-checked span	{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'simple-light','css' => '/* SIMPLE LIGHT SKIN DROP DOWN 1.1.0 */
.simple-light .esg-filterbutton 								{ 	color:#999 !important}

.simple-light .esg-selected-filterbutton						{	 border: 1px solid #E5E5E5;background: #eee; padding:5px 5px 5px 10px; color:#000; font-weight:400;}

.simple-light .esg-selected-filterbutton .eg-icon-down-open		{	margin-left:5px;font-size:9px; line-height: 20px; vertical-align: top; color:#000;}

.simple-light .esg-cartbutton:hover,
.simple-light .esg-selected-filterbutton:hover, 
.simple-light .esg-selected-filterbutton.hoveredfilter		{	background-color: #fff; border-color: #bbb; color: #333; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13); }

.simple-light .esg-filter-wrapper .esg-filterbutton span		{ color: #000;  }
.simple-light .esg-filter-wrapper .esg-filterbutton:hover span, 
.simple-light .esg-filter-wrapper .esg-filterbutton.selected span		{ color: #000 !important;  }
.simple-light .esg-filter-wrapper .esg-filterbutton:hover span i, 
.simple-light .esg-filter-wrapper .esg-filterbutton.selected span i		{ color: #fff !important;  }

.simple-light .esg-dropdown-wrapper								{	background:#fff; border: 1px solid #bbb; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);}
.simple-light .esg-dropdown-wrapper .esg-filterbutton			{	border:none !important;background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:400; text-align: left; }
.simple-light .esg-dropdown-wrapper .esg-filterbutton span { color:#777; }
.simple-light .esg-dropdown-wrapper .esg-filterbutton:hover,
.simple-light .esg-dropdown-wrapper .esg-filterbutton.selected	{	color:#000 !important; box-shadow: none !important}
.simple-light .esg-dropdown-wrapper .esg-filter-checked			{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important;}
.simple-light .esg-dropdown-wrapper .esg-filter-checked span	{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'simple-dark','css' => '/* SIMPLE DARK SKIN DROP DOWN */
.simple-dark .esg-filterbutton 									{ 	color:#fff !important}

.simple-dark .esg-selected-filterbutton							{	 border: 1px solid rgba(255, 255, 255, 0.15);background:rgba(255, 255, 255, 0.08);padding:5px 5px 5px 10px; color:#fff; font-weight:600;}

.simple-dark .esg-cartbutton									{	border: 1px solid rgba(255, 255, 255, 0.1) !important; }
.simple-dark .esg-cartbutton,
.simple-dark .esg-cartbutton a,
.simple-dark .esg-cartbutton a:visited,
.simple-dark .esg-cartbutton i,
.simple-dark .esg-cartbutton i.before						{	font-weight:600; color:#fff; }

.simple-dark .esg-cartbutton:hover a, 
.simple-dark .esg-cartbutton:hover i 							{ color: #000; }

.simple-dark .esg-selected-filterbutton:hover .eg-icon-down-open,
.simple-dark .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open		{	 color:#000; }
.simple-dark .esg-cartbutton:hover, 							
.simple-dark .esg-selected-filterbutton:hover, 
.simple-dark .esg-selected-filterbutton.hoveredfilter			{	border-color: #fff; color: #000; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13); background: #fff; }

.simple-dark .esg-selected-filterbutton .eg-icon-down-open		{	margin-left:5px;font-size:9px; line-height: 20px; vertical-align: top; color:#fff;}

.simple-dark .esg-filter-wrapper .esg-filterbutton:hover span, 
.simple-dark .esg-filter-wrapper .esg-filterbutton.selected span		{ color: #000 !important;  }

.simple-dark .esg-dropdown-wrapper								{	background:#fff; border: 1px solid #bbb; box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13); }

.simple-dark .esg-dropdown-wrapper .esg-filterbutton			{	border:none !important;background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:600; text-align: left; color:#777 !important; }
.simple-light .esg-dropdown-wrapper .esg-filterbutton span { color:#777; }
.simple-dark .esg-dropdown-wrapper .esg-filterbutton:hover,
.simple-dark .esg-dropdown-wrapper .esg-filterbutton.selected	{	color:#000 !important; box-shadow: none !important; font-weight: 600;}
.simple-dark .esg-dropdown-wrapper .esg-filter-checked			{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important; border: 1px solid #444;}
.simple-dark .esg-dropdown-wrapper .esg-filter-checked span		{	vertical-align: middle; line-height:20px;}'),
			array('handle' => 'text-dark','css' => '/* TEXT DARK SKIN DROP DOWN 1.1.0 */
.text-dark .esg-filterbutton 									{ 	color: #FFF;color: rgba(255, 255, 255, 0.4) !important}
	
.text-dark .esg-selected-filterbutton							{	padding:5px 5px 5px 10px; color: #FFF;color: rgba(255, 255, 255, 0.4);  font-weight:600;}

.text-dark .esg-cartbutton										{	 }
.text-dark .esg-cartbutton,
.text-dark .esg-cartbutton a,
.text-dark .esg-cartbutton a:visited,
.text-dark .esg-cartbutton a:hover,
.text-dark .esg-cartbutton i,
.text-dark .esg-cartbutton i.before							{	font-weight:600; color: #FFF; color: rgba(255, 255, 255, 0.4); }

.text-dark .esg-cartbutton:hover a, 
.text-dark .esg-cartbutton:hover i 								{ color: rgba(255, 255, 255, 1); }

.text-dark .esg-selected-filterbutton:hover .eg-icon-down-open,
.text-dark .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open		{	 color: rgba(255, 255, 255, 1); }
.text-dark .esg-cartbutton:hover, 							
.text-dark .esg-selected-filterbutton:hover, 
.text-dark .esg-selected-filterbutton.hoveredfilter				{	color: rgba(255, 255, 255, 1); }

.text-dark .esg-selected-filterbutton .eg-icon-down-open		{	margin-left:5px;font-size:9px; line-height: 20px; vertical-align: top; color: #FFF;color: rgba(255, 255, 255, 0.4); }

.text-dark .esg-filter-wrapper .esg-filterbutton:hover span, 
.text-dark .esg-filter-wrapper .esg-filterbutton.selected span	{ color: rgba(255, 255, 255, 1);  }

.text-dark .esg-dropdown-wrapper								{	border: 1px solid rgba(0, 0, 0, 0.15); background:#000; background:rgba(0, 0, 0, 0.95); }
.text-dark .esg-dropdown-wrapper .esg-filterbutton				{	border:none !important;background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:600; text-align: left; color:#999 !important; }
.text-dark .esg-dropdown-wrapper .esg-filterbutton span  		{   text-decoration: none !important; }
.text-dark .esg-dropdown-wrapper .esg-filterbutton:hover,
.text-dark .esg-dropdown-wrapper .esg-filterbutton.selected		{	color:#fff !important; box-shadow: none !important; }
.text-dark .esg-dropdown-wrapper .esg-filter-checked			{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important; border: 1px solid #444;}
.text-dark .esg-dropdown-wrapper .esg-filterbutton.selected .esg-filter-checked,
.text-dark .esg-dropdown-wrapper .esg-filterbutton:hover .esg-filter-checked	{	color:#fff;}

.text-dark .esg-dropdown-wrapper .esg-filter-checked span		{	vertical-align: middle; line-height:20px; color:#000;}'),
			array('handle' => 'text-light','css' => '/* TEXT LIGHT SKIN DROP DOWN 1.1.0 */
.text-light .esg-filterbutton 									{ 	color: #999}

.text-light .esg-selected-filterbutton							{	padding:5px 5px 5px 10px; color: #999; font-weight:600;}

.text-light .esg-cartbutton										{	 }
.text-light .esg-cartbutton,
.text-light .esg-cartbutton a,
.text-light .esg-cartbutton a:visited,
.text-light .esg-cartbutton a:hover,
.text-light .esg-cartbutton i,
.text-light .esg-cartbutton i.before							{	font-weight:600; color: #999; }

.text-light .esg-cartbutton:hover a, 
.text-light .esg-cartbutton:hover i 							{ color: #444; }

.text-light .esg-selected-filterbutton:hover .eg-icon-down-open,
.text-light .esg-selected-filterbutton.hoveredfilter .eg-icon-down-open		{	 color: #444; }
.text-light .esg-cartbutton:hover, 							
.text-light .esg-selected-filterbutton:hover, 
.text-light .esg-selected-filterbutton.hoveredfilter			{	color: #444; }

.text-light .esg-selected-filterbutton .eg-icon-down-open		{	margin-left:5px;font-size:9px; line-height: 20px; vertical-align: top; color: #999; }

.text-light .esg-filter-wrapper .esg-filterbutton:hover span, 
.text-light .esg-filter-wrapper .esg-filterbutton.selected span	{ text-decoration: none !important; }

.text-light .esg-dropdown-wrapper								{	border: 1px solid rgba(255, 255, 255, 0.15); background:#fff; background:rgba(255, 255, 255, 0.95); }
.text-light .esg-dropdown-wrapper .esg-filterbutton				{	border:none !important;background:transparent !important;line-height: 25px; white-space: nowrap; padding:0px 10px; font-weight:600; text-align: left; color:#999 !important; }
.text-light .esg-dropdown-wrapper .esg-filterbutton span  		{   text-decoration: none !important; }
.text-light .esg-dropdown-wrapper .esg-filterbutton:hover,
.text-light .esg-dropdown-wrapper .esg-filterbutton.selected	{	color:#000 !important; box-shadow: none !important; }
.text-light .esg-dropdown-wrapper .esg-filter-checked			{	display:inline-block; margin-left:0px !important;margin-right:7px; margin-top:-2px !important; line-height: 15px !important; border: 1px solid #ddd;}
.text-light .esg-dropdown-wrapper .esg-filterbutton.selected .esg-filter-checked,
.text-light .esg-dropdown-wrapper .esg-filterbutton:hover .esg-filter-checked	{	color:#000;}

.text-light .esg-dropdown-wrapper .esg-filter-checked span		{	vertical-align: middle; line-height:20px; color:#000;}')
		);
		
		foreach($navigation_skins as $skin){
			$old_skin = $nav->get_essential_navigation_skin_by_handle($skin['handle']);
			
			if($old_skin !== false){
				$old_skin['css'] .= "\n\n\n".$skin['css'];
				
				//modify variables to meet requirement for update function
				$old_skin['skin_css'] = $old_skin['css'];
				$old_skin['sid'] = $old_skin['id'];
				unset($old_skin['name']);
				unset($old_skin['css']);
				unset($old_skin['id']);
				
				$nav->update_create_navigation_skin_css($old_skin);
				
			}
			
		}
		
		$this->update_version('1.1.0');
		$this->set_version('1.1.0');
		
	}
	
	
	/**
	 * update to 2.0
	 * @since: 2.0
	 * @does: adds navigation skins to support search
	 */
	public function update_to_20(){
	
		//update navigation skins to support search
		$nav = new Essential_Grid_Navigation();
		
		$navigation_skins = array(
			array('handle' => 'flat-light','css' => '/* FLAT LIGHT SEARCH 2.0 */
.flat-light input.eg-search-input[type="text"]{	background: #FFF !important;padding: 0px 15px !important;
												color: #000 !important;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;line-height: 40px !important;border: none !important;box-shadow: none !important;
												font-size: 12px !important;text-transform: uppercase;font-weight: 700;
											}
.flat-light input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#000 !important}
.flat-light input.eg-search-input[type="text"]:-moz-placeholder { color:#000 !important}
.flat-light input.eg-search-input[type="text"]::-moz-placeholder { color:#000 !important}
.flat-light input.eg-search-input[type="text"]:-ms-input-placeholder	{ color:#000 !important}
.flat-light .eg-search-submit,
.flat-light .eg-search-clean  { background:#fff; color:#999; width:40px;height:40px; text-align: center; vertical-align: top; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;margin-left:5px;}
.flat-light .eg-search-submit:hover,
.flat-light .eg-search-clean:hover { color:#000;}'),
			array('handle' => 'flat-dark','css' => '/* FLAT DARK SEARCH 2.0 */
.flat-dark input.eg-search-input[type="text"]{	background: #3A3A3A !important; background: rgba(0, 0, 0, 0.2) !important;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;line-height: 40px !important;border: none !important;box-shadow: none !important;
												font-size: 12px !important;text-transform: uppercase;
												padding: 0px 15px !important;color: #fff !important;
											}
.flat-dark input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#fff !important}
.flat-dark input.eg-search-input[type="text"]:-moz-placeholder {	color:#fff !important}
.flat-dark input.eg-search-input[type="text"]::-moz-placeholder {	color:#fff !important}
.flat-dark input.eg-search-input[type="text"]:-ms-input-placeholder {	color:#fff !important}

.flat-dark input.eg-search-input[type="text"]:hover,
.flat-dark input.eg-search-input[type="text"]:focus { background: #4A4A4A !important;background: rgba(0, 0, 0, 0.5) !important;}
.flat-dark .eg-search-submit,
.flat-dark .eg-search-clean	{	background: #3A3A3A !important; background: rgba(0, 0, 0, 0.2) !important;
								color:#fff; width:40px;height:40px; text-align: center; vertical-align: top; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;margin-left:5px;
							}
.flat-dark .eg-search-submit:hover,
.flat-dark .eg-search-clean:hover { background: #4A4A4A !important;background: rgba(0, 0, 0, 0.5) !important;color:#fff;}'),
			array('handle' => 'minimal-dark','css' => '/* MINIMAL DARK SEARCH 2.0 */
.minimal-dark input.eg-search-input[type="text"] { background: transparent !important; background: rgba(0, 0, 0, 0) !important;
													padding: 0px 15px !important;color: #fff !important;line-height: 38px !important;
													border-radius: 5px 0px 0px 5px;-moz-border-radius: 5px 0px 0px 5px;-webkit-border-radius: 5px 0px 0px 5px;														
													border:1px solid #fff !important;border:1px solid rgba(255,255,255,0.1) !important;
													border-right: none !important;box-shadow: none !important;
													font-size: 12px !important;font-weight: 600;
												}
												
.minimal-dark input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#fff !important}
.minimal-dark input.eg-search-input[type="text"]:-moz-placeholder { color:#fff !important}
.minimal-dark input.eg-search-input[type="text"]::-moz-placeholder { color:#fff !important}
.minimal-dark input.eg-search-input[type="text"]:-ms-input-placeholder { color:#fff !important}

.minimal-dark input.eg-search-input[type="text"]:hover,
.minimal-dark input.eg-search-input[type="text"]:focus { background: transparent !important;background: rgba(255, 255, 255, 0.1) !important;border-color: rgba(255, 255, 255, 0.2) !important;box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.13) !important;}
.minimal-dark .eg-search-submit,
.minimal-dark .eg-search-clean { background: transparent !important; background: rgba(0, 0, 0, 0) !important;color:#fff; width:40px;height:40px; text-align: center; vertical-align: top; 
								border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;margin-left:0px;
								border:1px solid #fff !important;border:1px solid rgba(255,255,255,0.1) !important;
							}
.minimal-dark .eg-search-submit { border-left:none !important; border-right:none !important; border-radius:0;-webkit-border-radius:0;-moz-border-radius:0;}
.minimal-dark .eg-search-clean { border-left:none !important;  border-radius:0px 5px 5px 0px; -webkit-border-radius:0px 5px 5px 0px; -moz-border-radius:0px 5px 5px 0px}
.minimal-dark .eg-search-submit:hover,
.minimal-dark .eg-search-clean:hover { background: transparent !important;background: rgba(255, 255, 255, 0.1) !important;border-color: rgba(255, 255, 255, 0.2) !important;box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.13) !important;}'),
			array('handle' => 'minimal-light','css' => '/* MINIMAL LIGHT SEARCH 2.0 */
.minimal-light input.eg-search-input[type="text"] {	background: #fff !important;
													padding: 0px 15px !important;color: #999 !important;line-height: 38px !important;
													border-radius: 5px 0px 0px 5px;-moz-border-radius: 5px 0px 0px 5px;-webkit-border-radius: 5px 0px 0px 5px;
													border:1px solid #E5E5E5 !important;
													border-right: none !important;box-shadow: none !important;
													font-size: 12px !important;font-weight: 600;
												}
												
.minimal-light input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#999 !important}
.minimal-light input.eg-search-input[type="text"]:-moz-placeholder { color:#999 !important}
.minimal-light input.eg-search-input[type="text"]::-moz-placeholder { color:#999 !important}
.minimal-light input.eg-search-input[type="text"]:-ms-input-placeholder { color:#999 !important}

.minimal-light input.eg-search-input[type="text"]:hover,
.minimal-light input.eg-search-input[type="text"]:focus { background: #fff !important;border-color: #bbb !important;box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.13) !important;}
.minimal-light .eg-search-submit,
.minimal-light .eg-search-clean { background:#fff !important;color:#999; width:40px;height:40px; text-align: center; vertical-align: top; 
									border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;margin-left:0px;
									border:1px solid #E5E5E5 !important;
								}
.minimal-light .eg-search-submit { border-right:none !important; border-radius:0; -webkit-border-radius:0; -moz-border-radius:0;}
.minimal-light .eg-search-clean { border-radius:0px 5px 5px 0px; -webkit-border-radius:0px 5px 5px 0px; -moz-border-radius:0px 5px 5px 0px}
.minimal-light .eg-search-submit:hover,
.minimal-light .eg-search-clean:hover { background: #fff !important; border-color: #bbb !important; box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.13) !important;}'),
			array('handle' => 'simple-light','css' => '/* SIMPLE LIGHT SEARCH 2.0 */
.simple-light .eg-search-wrapper { line-height: 30px !important}
.simple-light input.eg-search-input[type="text"] { background: #eee !important; padding: 0px 15px !important;
												border: 1px solid #E5E5E5 !important;
												color: #000 !important; line-height: 30px !important; box-shadow: none !important;
												font-size: 12px !important; text-transform: uppercase; font-weight: 400;
												}
.simple-light input.eg-search-input[type="text"]:hover,
.simple-light input.eg-search-input[type="text"]:focus { background-color: #fff !important}
.simple-light input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#000 !important}
.simple-light input.eg-search-input[type="text"]:-moz-placeholder { color:#000 !important}
.simple-light input.eg-search-input[type="text"]::-moz-placeholder { color:#000 !important}
.simple-light input.eg-search-input[type="text"]:-ms-input-placeholder { color:#000 !important}
.simple-light .eg-search-submit,
.simple-light .eg-search-clean { border: 1px solid #E5E5E5 !important; background:#eee; color:#000; width:32px; height:32px; text-align: center; font-size:14px; 
								vertical-align: top; margin-left:5px;
							  }
.simple-light .eg-search-submit:hover,
.simple-light .eg-search-clean:hover { color:#000; background:#fff !important}'),
			array('handle' => 'simple-dark','css' => '/* SIMPLE DARK SEARCH 2.0 */
.simple-dark .eg-search-wrapper { line-height: 30px !important}
.simple-dark input.eg-search-input[type="text"] { background: rgba(255, 255, 255, 0.08) !important; padding: 0px 15px !important;
												border:1px solid rgba(255, 255, 255, 0.15) !important;
												color: #fff !important; line-height: 30px !important; box-shadow: none !important;
												font-size: 12px !important; font-weight: 600;
											  }
.simple-dark input.eg-search-input[type="text"]:hover,
.simple-dark input.eg-search-input[type="text"]:focus { background-color: #fff !important; color:#000 !important;}
.simple-dark input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#fff !important}
.simple-dark input.eg-search-input[type="text"]:-moz-placeholder { color:#fff !important}
.simple-dark input.eg-search-input[type="text"]::-moz-placeholder { color:#fff !important}
.simple-dark input.eg-search-input[type="text"]:-ms-input-placeholder { color:#fff !important}
.simple-dark input:hover.eg-search-input[type="text"]::-webkit-input-placeholder { color:#000 !important}
.simple-dark input:hover.eg-search-input[type="text"]:-moz-placeholder { color:#000 !important}
.simple-dark input:hover.eg-search-input[type="text"]::-moz-placeholder { color:#000 !important}
.simple-dark input:hover.eg-search-input[type="text"]:-ms-input-placeholder { color:#000 !important}

.simple-dark .eg-search-submit,
.simple-dark .eg-search-clean { border: 1px solid rgba(255, 255, 255, 0.15) !important; background: rgba(255, 255, 255, 0.08); 
								color:#fff; width:32px; height:32px; text-align: center; font-size:12px; 
								vertical-align: top;margin-left:5px;
							 }
.simple-dark .eg-search-submit:hover,
.simple-dark .eg-search-clean:hover{ color:#000; background:#fff !important}'),
			array('handle' => 'text-dark','css' => '/* TEXT DARK SEARCH 2.0 */
.text-dark .eg-search-wrapper {	line-height: 32px !important; vertical-align: middle !important}
.text-dark input.eg-search-input[type="text"] { background: transparent !important; padding: 0px 15px !important;
												border:none !important; margin-bottom:0px !important;
												color: #fff !important; color: rgba(255, 255, 255, 0.4) !important; line-height: 20px !important; box-shadow: none !important;
												font-size: 12px !important; font-weight: 600;
											}
.text-dark input.eg-search-input[type="text"]:hover,
.text-dark input.eg-search-input[type="text"]:focus {	 color:#fff !important;}
.text-dark input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#fff !important;color: rgba(255, 255, 255, 0.4) !important;}
.text-dark input.eg-search-input[type="text"]:-moz-placeholder { color:#fff !important; color: rgba(255, 255, 255, 0.4) !important;}
.text-dark input.eg-search-input[type="text"]::-moz-placeholder { color:#fff !important; color: rgba(255, 255, 255, 0.4) !important;}
.text-dark input.eg-search-input[type="text"]:-ms-input-placeholder { color:#fff !important; color: rgba(255, 255, 255, 0.4) !important;}
.text-dark input:hover.eg-search-input[type="text"]::-webkit-input-placeholder { color:#fff !important}
.text-dark input:hover.eg-search-input[type="text"]:-moz-placeholder { color:#fff !important}
.text-dark input:hover.eg-search-input[type="text"]::-moz-placeholder { color:#fff !important}
.text-dark input:hover.eg-search-input[type="text"]:-ms-input-placeholder { color:#fff !important}


.text-dark .eg-search-submit,
.text-dark .eg-search-clean { border: none !important; background: transparent; line-height:20px;vertical-align: middle;
								color:#fff;color: rgba(255, 255, 255, 0.4) !important;height:20px; text-align: center; font-size:12px; 
								margin-left:10px; padding-left:10px; border-left:1px solid #fff !important; border-left:1px solid rgba(255, 255, 255, 0.2) !important;
							}
.text-dark .eg-search-submit:hover,
.text-dark .eg-search-clean:hover{ color:#fff !important;}'),
			array('handle' => 'text-light','css' => '/* TEXT LIGHT SEARCH 2.0 */
.text-light .eg-search-wrapper { line-height: 32px !important; vertical-align: middle !important}
.text-light input.eg-search-input[type="text"] { background: transparent !important; padding: 0px 15px !important;
												border:none !important; margin-bottom:0px !important;
												color: #999 !important; line-height: 20px !important; box-shadow: none !important;
												font-size: 12px !important;font-weight: 600;
											}
.text-light input.eg-search-input[type="text"]:hover,
.text-light input.eg-search-input[type="text"]:focus	{ color:#444 !important;}
.text-light input.eg-search-input[type="text"]::-webkit-input-placeholder { color:#999 !important;}
.text-light input.eg-search-input[type="text"]:-moz-placeholder { color:#999 !important;}
.text-light input.eg-search-input[type="text"]::-moz-placeholder { color:#999 !important;}
.text-light input.eg-search-input[type="text"]:-ms-input-placeholder { color:#999 !important;}
.text-light input:hover.eg-search-input[type="text"]::-webkit-input-placeholder {	color:#444 !important}
.text-light input:hover.eg-search-input[type="text"]:-moz-placeholder { color:#444 !important}
.text-light input:hover.eg-search-input[type="text"]::-moz-placeholder { color:#444 !important}
.text-light input:hover.eg-search-input[type="text"]:-ms-input-placeholder { color:#444 !important}

.text-light .eg-search-submit,
.text-light .eg-search-clean { border: none !important; background: transparent; line-height:20px; vertical-align: middle;
								color:#999;height:20px; text-align: center; font-size:12px; 
								margin-left:10px; padding-left:10px; border-left:1px solid #e5e5e5 !important; 
							}
.text-light .eg-search-submit:hover,
.text-light .eg-search-clean:hover { color:#444 !important; }')
		);
		
		foreach($navigation_skins as $skin){
			$old_skin = $nav->get_essential_navigation_skin_by_handle($skin['handle']);
			
			if($old_skin !== false){
				$old_skin['css'] .= "\n\n\n".$skin['css'];
				
				//modify variables to meet requirement for update function
				$old_skin['skin_css'] = $old_skin['css'];
				$old_skin['sid'] = $old_skin['id'];
				unset($old_skin['name']);
				unset($old_skin['css']);
				unset($old_skin['id']);
				
				$nav->update_create_navigation_skin_css($old_skin);
				
			}
			
		}
		
		$this->update_version('2.0');
		$this->set_version('2.0');
		
	}
	
	
	/**
	 * update to 2.0.1
	 * @since: 2.0.1
	 * @does: adds navigation skins to support search further, fixing some missing styles
	 */
	public function update_to_201(){
		//update navigation skins to support search
		$nav = new Essential_Grid_Navigation();
		
		$navigation_skins = array(
			array('handle' => 'simple-light','css' => '/* SIMPLE LIGHT SEARCH 2.0.1 */
.simple-light input.eg-search-input[type="text"] {
	border-radius: 0px !important;
	height: 32px;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
}

.simple-light .eg-search-submit, .simple-light .eg-search-clean {
	width:32px;height:32px;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
}'),
			array('handle' => 'minimal-dark','css' => '/* MINIMAL DARK SEARCH 2.0.1 */
.minimal-dark input.eg-search-input[type="text"] {
	height: 40px;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
}
.minimal-dark .eg-search-submit, .minimal-dark .eg-search-clean {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
}'),
			array('handle' => 'minimal-light','css' => '/* MINIMAL LIGHT SEARCH 2.0.1 */
.minimal-light .eg-search-submit, .minimal-light .eg-search-clean {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
}'),
			array('handle' => 'simple-dark','css' => '/* SIMPLE DARK SEARCH 2.0.1 */
.simple-dark input.eg-search-input[type="text"] { box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 34px;
	border-radius: 0px !important;
}'));

		foreach($navigation_skins as $skin){
			$old_skin = $nav->get_essential_navigation_skin_by_handle($skin['handle']);
			
			if($old_skin !== false){
				$old_skin['css'] .= "\n\n\n".$skin['css'];
				
				//modify variables to meet requirement for update function
				$old_skin['skin_css'] = $old_skin['css'];
				$old_skin['sid'] = $old_skin['id'];
				unset($old_skin['name']);
				unset($old_skin['css']);
				unset($old_skin['id']);
				
				$nav->update_create_navigation_skin_css($old_skin);
				
			}
			
		}
		
		$this->update_version('2.0.1');
		$this->set_version('2.0.1');
	}
	
	
	/**
	 * update to 2.1.0
	 * @since: 2.1.0
	 * @does: adds new Item Skins and Global Styles
	 */
	public function update_to_210(){
		
		$skins = array(
			array('name' => 'FlickrStream','handle' => 'flickrstream','params' => '{"eg-item-skin-element-last-id":"19","choose-layout":"even","show-content":"bottom","content-align":"left","image-repeat":"no-repeat","image-fit":"cover","image-align-horizontal":"center","image-align-vertical":"center","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#000000","0":"Default","element-container-background-color-opacity":"50","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#222222","full-padding":["0","0","0","0"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"transparent","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#222222","content-padding":["0","0","0","0"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"none","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","0","0","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"fade","media-animation":"none","media-animation-delay":"0","link-set-to":"cover","link-link-type":"lightbox","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"1","order":0,"container":"br","settings":{"0":"Default","source":"icon","enable-hover":"","font-size":"16","line-height":"22","color":"#ffffff","font-family":"","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"none","display":"inline-block","text-align":"center","float":"right","clear":"none","margin":{"0":"0","1":"15","2":"10","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"60","1":"60","2":"60","3":"60"},"border-radius-unit":"px","border-color":"#ffffff","border-style":"solid","font-size-hover":"16","line-height-hover":"22","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"400","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#000000","bg-alpha-hover":"50","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"60","1":"60","2":"60","3":"60"},"border-radius-unit-hover":"px","border-color-hover":"#ffffff","border-style-hover":"solid","hideunder":"0","transition":"fade","delay":"0","link-type":"post","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","css":"","css-hover":"","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","hide-on-video":"","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","show-on-lightbox-video":"","source-icon":"eg-icon-link"}},null,{"id":"15","order":1,"container":"br","settings":{"0":"Default","source":"post","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"13","line-height":"19","color":"#ffffff","font-family":"","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"left","clear":"none","margin":["0","0","15","20"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"14","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#ffffff","bg-alpha-hover":"15","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"none","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","source-post":"title"}},null,{"id":"17","order":2,"container":"br","settings":{"0":"Default","source":"text","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"13","line-height":"19","color":"#ffffff","font-family":"","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"left","clear":"none","margin":["0","0","15","20"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"14","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#ffffff","bg-alpha-hover":"15","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"none","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","show-on-lightbox-video":"","source-text":"<i class=\"eg-icon-star-empty\"><\/i> %favorites%"}},{"id":"19","order":3,"container":"br","settings":{"0":"Default","source":"text","source-separate":",","source-function":"link","limit-type":"none","limit-num":"10","source-text-style-disable":"","enable-hover":"","font-size":"13","line-height":"19","color":"rgba(255,255,255,0.5)","font-family":"","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"left","clear":"none","margin":{"0":"0","1":"0","2":"15","3":"20"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"14","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#ffffff","bg-alpha-hover":"15","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hideunderheight":"0","hidetype":"visibility","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"none","url-link":"","meta-link":"","javascript-link":"","link-target":"_self","tag-type":"div","force-important":"true","facebook-sharing-link":"site","facebook-link-url":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","show-on-lightbox-video":"","source-text":"by %author_name%"}}]','settings' => '{"favorite":false}'),
			array('name' => 'FacebookStream','handle' => 'facebookstream','params' => '{"eg-item-skin-element-last-id":"33","choose-layout":"masonry","show-content":"top","content-align":"left","image-repeat":"no-repeat","image-fit":"cover","image-align-horizontal":"center","image-align-vertical":"center","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#365899","0":"Default","element-container-background-color-opacity":"65","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#ffffff","full-padding":["0","0","0","0"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"#e5e5e5","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#ffffff","content-padding":["30","30","26","30"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"double","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","1","10","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"none","media-animation":"none","media-animation-delay":"0","link-set-to":"none","link-link-type":"none","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"0","order":"0","container":"m","settings":{"0":"","source":"post","enable-hover":"","font-size":"14","line-height":"22","color":"#363839","font-family":"Arial, Helvetica, sans-serif","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"none","display":"block","text-align":"left","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"100","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"20","line-height-hover":"25","color-hover":"#13c0df","font-family-hover":"\"Raleway\"","font-weight-hover":"800","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"none","delay":"30","link-type":"post","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","tag-type":"div","force-important":"","align":"t_l","absolute-unit":"px","hide-on-video":"","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","show-on-lightbox-video":"","source-post":"title"}},{"id":"25","order":"0","container":"c","settings":{"0":"","source":"text","enable-hover":"on","font-size":"13","line-height":"20","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["0","0","0","0"],"padding":["5","10","3","10"],"background-color":"#000000","bg-alpha":"15","background-size":"cover","background-size-x":"100","background-size-y":"100","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"13","line-height-hover":"20","color-hover":"#ffffff","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#000000","bg-alpha-hover":"50","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"fade","delay":"0","link-type":"lightbox","url-link":"","javascript-link":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","transition-type":"","hide-on-video":"true","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","show-on-lightbox-video":"","source-text":"SHOW IMAGE"}},{"id":"28","order":"1","container":"c","settings":{"0":"Default","source":"text","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"on","font-size":"13","line-height":"20","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"uppercase","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["0","0","0","5"],"padding":["5","10","3","10"],"background-color":"#000000","bg-alpha":"15","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"20","color-hover":"#ffffff","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#000000","bg-alpha-hover":"50","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","transition":"fade","transition-type":"","delay":"0","link-type":"lightbox","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","show-on-lightbox-video":"true","source-text":"PLAY VIDEO"}},{"id":"3","order":"1","container":"m","settings":{"0":"","source":"text","enable-hover":"","font-size":"14","line-height":"22","color":"#365899","font-family":"Arial, Helvetica, sans-serif","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"capitalize","display":"inline-block","text-align":"center","float":"none","clear":"none","margin":{"0":"10","1":"15","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"100","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"#e5e5e5","border-style":"none","css":"","font-size-hover":"14","line-height-hover":"14","color-hover":"#000000","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"400","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"#e5e5e5","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"none","delay":"34","link-type":"none","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":", ","limit-type":"none","limit-num":"10","hide-on-video":"","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","show-on-sale":"","show-if-featured":"","show-on-lightbox-video":"","source-text":"<i class=\"eg-icon-thumbs-up-alt\" style=\"background:#365899;color:#fff;float:left;width:23px;height:23px;font-size:12px;text-align:center;border-radius:14px;margin-right:5px;\"><\/i> %likes_short%"}},{"id":"33","order":"2","container":"m","settings":{"0":"Default","source":"text","source-separate":", ","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"14","line-height":"22","color":"#90949c","font-family":"Arial, Helvetica, sans-serif","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"10","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"14","line-height-hover":"22","color-hover":"#7f7f7f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"900","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"skewleft","transition-type":"","delay":"10","link-type":"none","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","show-on-lightbox-video":"","source-text":"<i class=\"eg-icon-calendar-empty\" style=\"background:#90949c;color:#fff;float:left;width:23px;height:23px;font-size:12px;text-align:center;border-radius:14px;margin-right:5px;\"><\/i> %date%"}}]','settings' => '{"favorite":false}'),
			array('name' => 'YoutubeStream','handle' => 'youtubestream','params' => '{"eg-item-skin-element-last-id":"35","choose-layout":"masonry","show-content":"bottom","content-align":"left","image-repeat":"no-repeat","image-fit":"cover","image-align-horizontal":"center","image-align-vertical":"center","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#000000","0":"Default","element-container-background-color-opacity":"65","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#ffffff","full-padding":["0","0","0","0"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"#e5e5e5","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#ffffff","content-padding":["20","20","20","20"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"double","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","1","10","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"none","media-animation":"none","media-animation-delay":"0","link-set-to":"cover","link-link-type":"lightbox","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"0","order":"0","container":"m","settings":{"0":"","source":"post","enable-hover":"on","font-size":"14","line-height":"19","color":"#167ac6","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"capitalize","display":"block","text-align":"left","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"100","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"14","line-height-hover":"19","color-hover":"#167ac6","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"800","text-decoration-hover":"underline","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"none","delay":"30","link-type":"post","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","hide-on-video":"","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","show-on-lightbox-video":"","source-post":"title"}},{"id":"25","order":"0","container":"c","settings":{"0":"","source":"icon","enable-hover":"","font-size":"60","line-height":"60","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["0","0","0","0"],"padding":["0","0","0","0"],"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-size-x":"100","background-size-y":"100","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"60","line-height-hover":"60","color-hover":"rgba(255,255,255,0.85)","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"transparent","bg-alpha-hover":"0","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"zoomback","delay":"0","link-type":"lightbox","url-link":"","javascript-link":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","transition-type":"","hide-on-video":"true","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","source-icon":"eg-icon-play"}},{"id":"33","order":"1","container":"m","settings":{"0":"Default","source":"text","source-separate":", ","limit-type":"chars","limit-num":"100","enable-hover":"","font-size":"14","line-height":"22","color":"#90949c","font-family":"Arial, Helvetica, sans-serif","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"10","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"14","line-height-hover":"22","color-hover":"#7f7f7f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"900","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"skewleft","transition-type":"","delay":"10","link-type":"post","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","show-on-lightbox-video":"","source-text":"%views_short% views"}},{"id":"34","order":"2","container":"m","settings":{"0":"Default","source":"text","source-separate":", ","source-function":"link","limit-type":"none","limit-num":"10","source-text-style-disable":"","enable-hover":"","font-size":"12","line-height":"12","color":"#90949c","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"capitalize","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"none","margin":{"0":"0","1":"5","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"100","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"#e5e5e5","border-style":"none","font-size-hover":"13","line-height-hover":"22","color-hover":"#e81c4f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"#e5e5e5","border-style-hover":"none","hideunder":"0","hideunderheight":"0","hidetype":"visibility","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"none","transition-type":"","delay":"34","link-type":"post","url-link":"","meta-link":"","javascript-link":"","link-target":"_blank","tag-type":"div","force-important":"true","facebook-sharing-link":"","facebook-link-url":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","show-on-lightbox-video":"","source-text":"<i class=\"eg-icon-thumbs-up-1\"><\/i>%likes_short%"}},{"id":"35","order":"3","container":"m","settings":{"0":"Default","source":"text","source-separate":", ","source-function":"link","limit-type":"none","limit-num":"10","source-text-style-disable":"","enable-hover":"","font-size":"12","line-height":"12","color":"#90949c","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"capitalize","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"none","margin":{"0":"0","1":"5","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#ffffff","bg-alpha":"100","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"#e5e5e5","border-style":"none","font-size-hover":"13","line-height-hover":"22","color-hover":"#e81c4f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"#e5e5e5","border-style-hover":"none","hideunder":"0","hideunderheight":"0","hidetype":"visibility","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"none","transition-type":"","delay":"34","link-type":"post","url-link":"","meta-link":"","javascript-link":"","link-target":"_blank","tag-type":"div","force-important":"true","facebook-sharing-link":"site","facebook-link-url":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","show-on-lightbox-video":"","source-text":"<i class=\"eg-icon-thumbs-down\"><\/i>%dislikes_short%"}}]','settings' => '{"favorite":false}'),
			array('name' => 'TwitterStream','handle' => 'twitterstream','params' => '{"eg-item-skin-element-last-id":"38","choose-layout":"masonry","show-content":"top","content-align":"left","image-repeat":"no-repeat","image-fit":"cover","image-align-horizontal":"center","image-align-vertical":"center","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#292f33","0":"Default","element-container-background-color-opacity":"20","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#ffffff","full-padding":["30","30","30","30"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"#e5e5e5","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#ffffff","content-padding":["0","0","20","0"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"double","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","1","10","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"none","media-animation":"zoomtodefault","media-animation-delay":"0","link-set-to":"none","link-link-type":"none","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"25","order":"0","container":"c","settings":{"0":"","source":"icon","enable-hover":"on","font-size":"30","line-height":"30","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-size-x":"100","background-size-y":"100","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"30","line-height-hover":"30","color-hover":"rgba(255,255,255,0.85)","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"transparent","bg-alpha-hover":"0","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"fade","delay":"0","link-type":"lightbox","url-link":"","javascript-link":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","transition-type":"","hide-on-video":"true","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","show-on-lightbox-video":"","source-icon":"eg-icon-search"}},{"id":"37","order":"0","container":"br","settings":{"0":"Default","source":"text","source-separate":", ","source-function":"link","limit-type":"none","limit-num":"10","source-text-style-disable":"","enable-hover":"","font-size":"13","line-height":"22","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"capitalize","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"left","clear":"none","margin":{"0":"0","1":"0","2":"10","3":"15"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"transparent","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"#e5e5e5","border-style":"none","font-size-hover":"13","line-height-hover":"22","color-hover":"#e81c4f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"#e5e5e5","border-style-hover":"none","hideunder":"0","hideunderheight":"0","hidetype":"visibility","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"slideshortup","transition-type":"","delay":"0","link-type":"post","url-link":"","meta-link":"","javascript-link":"","link-target":"_blank","tag-type":"div","force-important":"true","facebook-sharing-link":"","facebook-link-url":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","show-on-lightbox-video":"","source-text":"@%author_name%"}},{"id":"35","order":"0","container":"m","settings":{"0":"Default","source":"post","source-separate":",","limit-type":"none","limit-num":"40","enable-hover":"on","font-size":"26","line-height":"32","color":"#292f33","font-family":"Arial, Helvetica, sans-serif","font-weight":"300","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"block","text-align":"left","float":"none","clear":"none","margin":["0","0","10","0"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"26","line-height-hover":"32","color-hover":"#0084b4","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"300","text-decoration-hover":"underline","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"none","transition-type":"","delay":"30","link-type":"post","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-lightbox-video":"","source-post":"title"}},null,{"id":"33","order":"1","container":"m","settings":{"0":"Default","source":"text","source-separate":", ","limit-type":"none","limit-num":"10","enable-hover":"on","font-size":"13","line-height":"22","color":"#aab8c2","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["0","15","0","0"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"22","color-hover":"#19cf68","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"skewleft","transition-type":"","delay":"10","link-type":"sharetwitter","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","source-text":"<i class=\"eg-icon-shuffle-1\"><\/i> %retweets%"}},{"id":"36","order":"1","container":"c","settings":{"0":"Default","source":"icon","source-separate":",","source-function":"link","limit-type":"none","limit-num":"10","source-text-style-disable":"","enable-hover":"on","font-size":"30","line-height":"30","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"transparent","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"30","line-height-hover":"30","color-hover":"rgba(255,255,255,0.85)","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"transparent","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hideunderheight":"0","hidetype":"visibility","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"lightbox","url-link":"","meta-link":"","javascript-link":"","link-target":"_self","tag-type":"div","force-important":"true","facebook-sharing-link":"","facebook-link-url":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","show-on-lightbox-video":"true","source-icon":"eg-icon-play"}},{"id":"3","order":"2","container":"m","settings":{"0":"","source":"text","enable-hover":"on","font-size":"13","line-height":"22","color":"#aab8c2","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"capitalize","display":"inline-block","text-align":"center","float":"none","clear":"none","margin":["0","15","0","0"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"100","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"#e5e5e5","border-style":"none","css":"","font-size-hover":"13","line-height-hover":"22","color-hover":"#e81c4f","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"#e5e5e5","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"none","delay":"34","link-type":"post","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":", ","limit-type":"none","limit-num":"10","hide-on-video":"","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","show-on-sale":"","show-if-featured":"","source-text":"<i class=\"eg-icon-heart\"><\/i> %likes%"}}]','settings' => '{"favorite":false}'),
			array('name' => 'VimeoStream','handle' => 'vimeostream','params' => '{"eg-item-skin-element-last-id":"34","choose-layout":"even","show-content":"none","content-align":"left","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#000000","0":"Default","element-container-background-color-opacity":"65","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#ffffff","full-padding":["0","0","0","0"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"#e5e5e5","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#ffffff","content-padding":["20","20","20","20"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"double","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","1","10","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"none","media-animation":"none","media-animation-delay":"0","link-set-to":"none","link-link-type":"lightbox","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"0","order":"0","container":"c","settings":{"0":"","source":"post","enable-hover":"","font-size":"24","line-height":"28","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"capitalize","display":"block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"10","2":"0","3":"10"},"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"24","line-height-hover":"28","color-hover":"#ffffff","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"900","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"transparent","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"fade","delay":"0","link-type":"post","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","hide-on-video":"","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","source-post":"title"}},{"id":"34","order":"0","container":"br","settings":{"0":"Default","source":"text","source-separate":",","limit-type":"none","limit-num":"3","enable-hover":"","font-size":"12","line-height":"12","color":"rgba(255,255,255,0.5)","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"uppercase","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"block","text-align":"center","float":"none","clear":"both","margin":["0","0","10","0"],"padding":["0","0","0","0"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"13","line-height-hover":"14","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#ffffff","bg-alpha-hover":"15","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"slideshortup","transition-type":"","delay":"30","link-type":"post","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","source-text":"%duration%"}},{"id":"33","order":"1","container":"c","settings":{"0":"Default","source":"text","source-separate":", ","limit-type":"chars","limit-num":"100","enable-hover":"","font-size":"18","line-height":"22","color":"#99aabc","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"block","text-align":"center","float":"none","clear":"both","margin":["5","0","0","0"],"padding":["0","10","0","10"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"18","line-height-hover":"22","color-hover":"#99aabc","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"none","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","source-text":"by %author_name%"}},{"id":"25","order":"2","container":"c","settings":{"0":"","source":"text","enable-hover":"on","font-size":"14","line-height":"40","color":"#44bbff","font-family":"Arial, Helvetica, sans-serif","font-weight":"700","text-decoration":"none","font-style":"","text-transform":"none","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["10","0","0","0"],"padding":["0","30","0","30"],"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-size-x":"100","background-size-y":"100","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["2","2","2","2"],"border-radius":["4","4","4","4"],"border-radius-unit":"px","border-color":"#44bbff","border-style":"solid","css":"","font-size-hover":"14","line-height-hover":"40","color-hover":"#ffffff","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"transparent","bg-alpha-hover":"0","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["2","2","2","2"],"border-radius-hover":["4","4","4","4"],"border-radius-unit-hover":"px","border-color-hover":"#ffffff","border-style-hover":"solid","css-hover":"","hideunder":"0","transition":"fade","delay":"0","link-type":"lightbox","url-link":"","javascript-link":"","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","transition-type":"","hide-on-video":"true","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","source-text":"Play Video"}}]','settings' => '{"favorite":false}'),
			array('name' => 'InstagramStream','handle' => 'instagramstream','params' => '{"eg-item-skin-element-last-id":"37","choose-layout":"even","show-content":"none","content-align":"left","image-repeat":"no-repeat","image-fit":"cover","image-align-horizontal":"center","image-align-vertical":"center","element-x-ratio":"4","element-y-ratio":"3","cover-type":"full","container-background-color":"#000000","0":"Default","element-container-background-color-opacity":"50","cover-background-size":"cover","cover-background-repeat":"no-repeat","cover-background-image":"0","cover-background-image-url":"","full-bg-color":"#ffffff","full-padding":["0","0","0","0"],"full-border":["0","0","0","0"],"full-border-radius":["0","0","0","0"],"full-border-color":"#e5e5e5","full-border-style":"none","full-overflow-hidden":"false","content-bg-color":"#ffffff","content-padding":["20","20","20","20"],"content-border":["0","0","0","0"],"content-border-radius":["0","0","0","0"],"content-border-color":"transparent","content-border-style":"double","all-shadow-used":"none","content-shadow-color":"#000000","content-shadow-alpha":"100","content-box-shadow":["0","1","10","0"],"cover-animation-top-type":"","cover-animation-delay-top":"0","cover-animation-top":"fade","cover-animation-center-type":"","cover-animation-delay-center":"0","cover-animation-center":"fade","cover-animation-bottom-type":"","cover-animation-delay-bottom":"0","cover-animation-bottom":"fade","cover-group-animation":"none","media-animation":"none","media-animation-delay":"0","link-set-to":"cover","link-link-type":"lightbox","link-url-link":"","link-meta-link":"","link-javascript-link":"","link-target":"_self"}','layers' => '[{"id":"0","order":"0","container":"c","settings":{"0":"","source":"text","enable-hover":"","font-size":"16","line-height":"16","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"uppercase","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"5","2":"0","3":"5"},"background-color":"transparent","bg-alpha":"0","background-size":"cover","background-repeat":"no-repeat","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","css":"","font-size-hover":"24","line-height-hover":"28","color-hover":"#ffffff","font-family-hover":"Arial, Helvetica, sans-serif","font-weight-hover":"900","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"transparent","bg-alpha-hover":"100","background-size-hover":"cover","background-size-x-hover":"100","background-size-y-hover":"100","background-repeat-hover":"no-repeat","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","css-hover":"","hideunder":"0","transition":"fade","delay":"0","link-type":"lightbox","url-link":"","javascript-link":"","margin-unit":"px","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","transition-type":"","position":"relative","top-bottom":"0","left-right":"0","source-separate":",","limit-type":"none","limit-num":"10","tag-type":"div","force-important":"true","align":"t_l","absolute-unit":"px","hide-on-video":"false","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","border-unit-hover":"px","box-shadow-unit-hover":"px","show-on-sale":"","show-if-featured":"","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","show-on-lightbox-video":"hide","source-text":"<i class=\"eg-icon-heart\"><\/i> %likes_short%"}},{"id":"35","order":"0","container":"tl","settings":{"0":"Default","source":"icon","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"24","line-height":"22","color":"#ffffff","font-family":"","font-weight":"400","text-decoration":"none","font-style":"","text-transform":"none","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"right","clear":"none","margin":{"0":"10","1":"7","2":"0","3":"0"},"padding":{"0":"0","1":"0","2":"0","3":"0"},"background-color":"#2d3039","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"#ffffff","border-style":"solid","font-size-hover":"24","line-height-hover":"22","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"400","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"none","background-color-hover":"#2d3039","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"60","1":"60","2":"60","3":"60"},"border-radius-unit-hover":"px","border-color-hover":"#ffffff","border-style-hover":"solid","hideunder":"0","hide-on-video":"false","show-on-sale":"","show-if-featured":"","transition":"none","transition-type":"","delay":"0","link-type":"lightbox","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_self","source-text-style-disable":"","margin-unit":"px","border-hover-unit":"px","border-radius-hover-unit":"px","box-shadow-hover-unit":"px","adv-rules":{"ar-show":"show","ar-type":["off","off","off","off","off","off","off","off","off"],"ar-meta":["","","","","","","","",""],"ar-operator":["isset","isset","isset","isset","isset","isset","isset","isset","isset"],"ar-value":["","","","","","","","",""],"ar-value-2":["","","","","","","","",""],"ar-logic":["and","and","and","and","and","and"],"ar-logic-glob":["and","and"]},"show-on-lightbox-video":"true","source-icon":"eg-icon-videocam"}},{"id":"37","order":"1","container":"c","settings":{"0":"Default","source":"text","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"16","line-height":"16","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"uppercase","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":{"0":"0","1":"0","2":"0","3":"0"},"padding":{"0":"0","1":"5","2":"0","3":"5"},"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":{"0":"0","1":"0","2":"0","3":"0"},"border":{"0":"0","1":"0","2":"0","3":"0"},"border-radius":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"20","line-height-hover":"25","color-hover":"#ffffff","font-family-hover":"\"Raleway\"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"capitalize","background-color-hover":"#ffffff","bg-alpha-hover":"0","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-hover":{"0":"0","1":"0","2":"0","3":"0"},"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"false","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"lightbox","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","show-on-lightbox-video":"true","link-target":"_self","source-text-style-disable":"","margin-unit":"px","source-text":"<i class=\"eg-icon-play\"><\/i> %likes_short%"}},{"id":"36","order":"2","container":"c","settings":{"0":"Default","source":"text","source-separate":",","limit-type":"none","limit-num":"10","enable-hover":"","font-size":"16","line-height":"16","color":"#ffffff","font-family":"Arial, Helvetica, sans-serif","font-weight":"900","text-decoration":"none","font-style":"","text-transform":"uppercase","position":"relative","align":"t_l","absolute-unit":"px","top-bottom":"0","left-right":"0","display":"inline-block","text-align":"center","float":"none","clear":"both","margin":["0","0","0","0"],"padding":["0","5","0","5"],"background-color":"#ffffff","bg-alpha":"0","shadow-color":"#000000","shadow-alpha":"100","box-shadow":["0","0","0","0"],"border":["0","0","0","0"],"border-radius":["0","0","0","0"],"border-radius-unit":"px","border-color":"transparent","border-style":"none","font-size-hover":"17","line-height-hover":"14","color-hover":"#ffffff","font-family-hover":"","font-weight-hover":"700","text-decoration-hover":"none","font-style-hover":"","text-transform-hover":"uppercase","background-color-hover":"#ffffff","bg-alpha-hover":"15","shadow-color-hover":"#000000","shadow-alpha-hover":"100","box-shadow-hover":["0","0","0","0"],"border-hover":["0","0","0","0"],"border-radius-hover":["0","0","0","0"],"border-radius-unit-hover":"px","border-color-hover":"transparent","border-style-hover":"none","hideunder":"0","hide-on-video":"false","show-on-sale":"","show-if-featured":"","transition":"fade","transition-type":"","delay":"0","link-type":"post","url-link":"","meta-link":"","javascript-link":"","tag-type":"div","force-important":"true","padding-unit":"px","border-unit":"px","box-shadow-unit":"px","source-function":"link","hideunderheight":"0","hidetype":"visibility","link-target":"_blank","source-text-style-disable":"","margin-unit":"px","show-on-lightbox-video":"false","source-text":"<i class=\"eg-icon-align-left\"><\/i> %num_comments%"}}]','settings' => '{"favorite":false}')
		);
		
		//Item Skins
		if(function_exists('is_multisite') && is_multisite()){ //do for each existing site
			global $wpdb;
			
			$old_blog = $wpdb->blogid;
			
			// Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);
			
			foreach($blogids as $blog_id){
				switch_to_blog($blog_id);
				
				$skins = apply_filters('essgrid_propagate_default_item_skins_multisite_update_to_210', $skins, $blog_id);
				
				Essential_Grid_Item_Skin::insert_default_item_skins($skins);
			}
			
			switch_to_blog($old_blog); //go back to correct blog
			
		}else{
		
			$skins = apply_filters('essgrid_propagate_default_item_skins_update_to_210', $skins);
			
			Essential_Grid_Item_Skin::insert_default_item_skins($skins);
		}
		
		
		$new_css = '
		
/*TWITTER STREAM*/
.esg-content.eg-twitterstream-element-33-a { display: inline-block; }
.eg-twitterstream-element-35 { word-break: break-all; } 
.esg-overlay.eg-twitterstream-container {background: -moz-linear-gradient(top, rgba(0,0,0,0) 50%, rgba(0,0,0,0.83) 99%, rgba(0,0,0,0.85) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,rgba(0,0,0,0)), color-stop(99%,rgba(0,0,0,0.83)), color-stop(100%,rgba(0,0,0,0.85))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00000000\', endColorstr=\'#d9000000\',GradientType=0 ); /* IE6-9 */}

/*FACEBOOK STREAM*/
.esg-content.eg-facebookstream-element-33-a { display: inline-block; }
.eg-facebookstream-element-0 { word-break: break-all; } 

/*FLICKR STREAM*/
.esg-overlay.eg-flickrstream-container {background: -moz-linear-gradient(top, rgba(0,0,0,0) 50%, rgba(0,0,0,0.83) 99%, rgba(0,0,0,0.85) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,rgba(0,0,0,0)), color-stop(99%,rgba(0,0,0,0.83)), color-stop(100%,rgba(0,0,0,0.85))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(0,0,0,0) 50%,rgba(0,0,0,0.83) 99%,rgba(0,0,0,0.85) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00000000\', endColorstr=\'#d9000000\',GradientType=0 ); /* IE6-9 */}
';
		
		//Global Styles
		if(function_exists('is_multisite') && is_multisite()){ //do for each existing site
			global $wpdb;
			
			$old_blog = $wpdb->blogid;
			
			// Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);
			
			foreach($blogids as $blog_id){
				switch_to_blog($blog_id);
				
				$css = Essential_Grid_Global_Css::get_global_css_styles();
				
				Essential_Grid_Global_Css::set_global_css_styles(apply_filters('essgrid_propagate_default_global_css_multisite_update_to_210', $css.$new_css, $blog_id));
				
			}
			
			switch_to_blog($old_blog); //go back to correct blog
			
		}else{
			$css = Essential_Grid_Global_Css::get_global_css_styles();
			Essential_Grid_Global_Css::set_global_css_styles(apply_filters('essgrid_propagate_default_global_css_update_to_210', $css.$new_css));
		}
		
		$this->update_version('2.1.0');
		$this->set_version('2.1.0');
	}
}