<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class RevSliderElementsBase {
	
	protected $db;
	
	public function __construct(){
		
		$this->db = new RevSliderDB();
	}
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteElementsBaseRev extends RevSliderElementsBase {}
?>