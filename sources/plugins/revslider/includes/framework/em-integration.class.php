<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderEventsManager {
	
	const DEFAULT_FILTER = "none";
	
	/**
	 * 
	 * check if events class exists
	 */
	public static function isEventsExists(){
		if(defined("EM_VERSION") && defined("EM_PRO_MIN_VERSION"))
			return(true);
			
		return(false);
	}
	
	
	/**
	 * 
	 * get sort by list
	 */
	public static function getArrFilterTypes(){
		
			$arrEventsSort = array("none" => __("All Events",'revslider'),
								   "today" => __("Today",'revslider'),
								   "tomorrow"=>__("Tomorrow",'revslider'),
								   "future"=>__("Future",'revslider'),
								   "past"=>__("Past",'revslider'),
								   "month"=>__("This Month",'revslider'),
								   "nextmonth"=>__("Next Month",'revslider')
			);
			
		return($arrEventsSort);
	}
	
	
	/**
	 * 
	 * get meta query
	 */
	public static function getWPQuery($filterType, $sortBy){
		$response = array();
		
		$dayMs = 60*60*24;
		
		$time = current_time('timestamp');
		$todayStart = strtotime(date('Y-m-d', $time));
		$todayEnd = $todayStart + $dayMs-1;
		$tomorrowStart = $todayEnd+1;
		$tomorrowEnd = $tomorrowStart + $dayMs-1;
		
		$start_month = strtotime(date('Y-m-1',$time));
		$end_month = strtotime(date('Y-m-t',$time)) + 86399;
		$next_month_middle = strtotime('+1 month', $time); //get the end of this month + 1 day
		$start_next_month = strtotime(date('Y-m-1',$next_month_middle));
		$end_next_month = strtotime(date('Y-m-t',$next_month_middle)) + 86399;
		
		$query = array();
		
		switch($filterType){
			case self::DEFAULT_FILTER:	//none
			break;
			case "today":
				$query[] = array( 'key' => '_start_ts', 'value' => $todayEnd, 'compare' => '<=' );
				$query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '>=' );
			break;
			case "future":
				$query[] = array( 'key' => '_start_ts', 'value' => $time, 'compare' => '>' );
			break;
			case "tomorrow":
				$query[] = array( 'key' => '_start_ts', 'value' => $tomorrowEnd, 'compare' => '<=' );
				$query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '>=' );	
			break;
			case "past":
				$query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '<' );
			break;
			case "month":
				$query[] = array( 'key' => '_start_ts', 'value' => $end_month, 'compare' => '<=' );
				$query[] = array( 'key' => '_end_ts', 'value' => $start_month, 'compare' => '>=' );					
			break;
			case "nextmonth":
				$query[] = array( 'key' => '_start_ts', 'value' => $end_next_month, 'compare' => '<=' );
				$query[] = array( 'key' => '_end_ts', 'value' => $start_next_month, 'compare' => '>=' );
			break;
			default:
				RevSliderFunctions::throwError("Wrong event filter");
			break;
		} 
		
		if(!empty($query))
			$response["meta_query"] = $query;
		
		//convert sortby
		switch($sortBy){
			case "event_start_date":
				$response["orderby"] = "meta_value_num";
				$response["meta_key"] = "_start_ts";
			break;
			case "event_end_date":
				$response["orderby"] = "meta_value_num";
				$response["meta_key"] = "_end_ts";
			break;
		}			
		
		return($response);
	}
	
	/**
	 * 
	 * get event post data in array. 
	 * if the post is not event, return empty array
	 */
	public static function getEventPostData($postID){
		if(self::isEventsExists() == false)
			return(array());
		
		$postType = get_post_type($postID);
		if($postType != EM_POST_TYPE_EVENT)
			return(array());
		
		$event = new EM_Event($postID, 'post_id');
		$location = $event->get_location();
		
		$arrEvent = $event->to_array();
		$arrLocation = $location->to_array();
		$date_format = get_option('date_format');
		$time_format = get_option('time_format');
		
		$arrEvent["event_start_date"] = date_format(date_create_from_format('Y-m-d', $arrEvent["event_start_date"]), $date_format);
		$arrEvent["event_end_date"] = date_format(date_create_from_format('Y-m-d', $arrEvent["event_end_date"]), $date_format);
		$arrEvent["event_start_time"] = date_format(date_create_from_format('H:i:s', $arrEvent["event_start_time"]), $time_format);
		$arrEvent["event_end_time"] = date_format(date_create_from_format('H:i:s', $arrEvent["event_end_time"]), $time_format);	
		
		$response = array();
		$response["start_date"] = $arrEvent["event_start_date"];
		$response["end_date"] = $arrEvent["event_end_date"];
		$response["start_time"] = $arrEvent["event_start_time"];
		$response["end_time"] = $arrEvent["event_end_time"];
		$response["id"] = $arrEvent["event_id"];
		$response["location_name"] = $arrLocation["location_name"];
		$response["location_address"] = $arrLocation["location_address"];
		$response["location_slug"] = $arrLocation["location_slug"];
		$response["location_town"] = $arrLocation["location_town"];
		$response["location_state"] = $arrLocation["location_state"];
		$response["location_postcode"] = $arrLocation["location_postcode"];
		$response["location_region"] = $arrLocation["location_region"];
		$response["location_country"] = $arrLocation["location_country"];
		$response["location_latitude"] = $arrLocation["location_latitude"];
		$response["location_longitude"] = $arrLocation["location_longitude"];
		
		return($response);
	}
	
	/**
	 * 
	 * get events sort by array
	 */
	public static function getArrSortBy(){
		$arrSortBy = array();
		$arrSortBy["event_start_date"] = __("Event Start Date",'revslider');
		$arrSortBy["event_end_date"] = __("Event End Date",'revslider');
		return($arrSortBy);			
	}
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteEmRev extends RevSliderEventsManager {}
?>