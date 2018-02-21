<?php

/**
 * EasySocialShareButtons CoreExtender: Tweet Optimization
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBCoreExtenderTweetOptimization {
	
	public static function twitter_message_optimization($tweet, $url, $user, $hashtags, $method = '1') {
		global $essb_options;
		$max_message_length = 280;
	
		$twitter_message_optimize_dots = ESSBOptionValuesHelper::options_bool_value($essb_options, 'twitter_message_optimize_dots');
	
		$current_message_length = self::twitter_message_length($tweet, $url, $user, $hashtags);
	
		$result = array();
		$result['tweet'] = $tweet;
		$result['hashtags'] = $hashtags;
		$result['user'] = $user;
	
		if ($current_message_length < $max_message_length) {
			return $result;
		} else {
			switch ($method) {
				case "1" :
					$result ['hashtags'] = '';
					$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						
					if ($current_message_length > $max_message_length) {
						$result ['user'] = '';
						$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
	
						if ($current_message_length > $max_message_length) {
							$length = self::twitter_maximum_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
							if ($twitter_message_optimize_dots) {
								$length -= 3;
							}
							$last_space = strrpos ( substr ( $result ['tweet'], 0, $length ), '+' );
							$trimmed_text = substr ( $result ['tweet'], 0, $last_space );
							if ($twitter_message_optimize_dots) {
								$trimmed_text .= '...';
							}
							$result ['tweet'] = $trimmed_text;
						}
					}
					break;
				case "2" :
					$result ['user'] = '';
					$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						
					if ($current_message_length > $max_message_length) {
						$result ['hashtags'] = '';
						$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
	
						if ($current_message_length > $max_message_length) {
							$length = self::twitter_maximum_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
							if ($twitter_message_optimize_dots) {
								$length -= 3;
							}
							$last_space = strrpos ( substr ( $result ['tweet'], 0, $length ), '+' );
							$trimmed_text = substr ( $result ['tweet'], 0, $last_space );
							if ($twitter_message_optimize_dots) {
								$trimmed_text .= '...';
							}
							$result ['tweet'] = $trimmed_text;
						}
							
					}
					break;
				case "3" :
					$result ['user'] = '';
					$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						
					if ($current_message_length > $max_message_length) {
	
						$length = self::twitter_maximum_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						if ($twitter_message_optimize_dots) {
							$length -= 3;
						}
						$last_space = strrpos ( substr ( $result ['tweet'], 0, $length ), '+' );
						$trimmed_text = substr ( $result ['tweet'], 0, $last_space );
						if ($twitter_message_optimize_dots) {
							$trimmed_text .= '...';
						}
	
						$result ['tweet'] = $trimmed_text;
							
					}
					break;
				case "4" :
					$result ['hashtags'] = '';
					$current_message_length = self::twitter_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						
					if ($current_message_length > $max_message_length) {
	
						$length = self::twitter_maximum_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
						if ($twitter_message_optimize_dots) {
							$length -= 3;
						}
						$last_space = strrpos ( substr ( $result ['tweet'], 0, $length ), '+' );
						$trimmed_text = substr ( $result ['tweet'], 0, $last_space );
						if ($twitter_message_optimize_dots) {
							$trimmed_text .= '...';
						}
	
						$result ['tweet'] = $trimmed_text;
							
					}
					break;
				case "5" :
					$length = self::twitter_maximum_message_length ( $result ['tweet'], $url, $result ['user'], $result ['hashtags'] );
					if ($twitter_message_optimize_dots) {
						$length -= 3;
					}
					
					if ($length > $max_message_length) {
						$last_space = strrpos ( substr ( $result ['tweet'], 0, $length ), '+' );
						$trimmed_text = substr ( $result ['tweet'], 0, $last_space );
						if ($twitter_message_optimize_dots) {
							$trimmed_text .= '...';
						}
							
						$result ['tweet'] = $trimmed_text;
					}
					break;
			}
				
			return $result;
		}
	}
	
	public static function twitter_message_length($tweet, $url, $user, $hashtags) {
		$current_message_length = strlen($tweet);
		$current_message_length += strlen($url) + 1;
		$current_message_length += strlen($hashtags);
		if (!empty($hashtags)) {
			$number_of_tags = substr_count($hashtags, ',');
			$number_of_tags++;
	
			$current_message_length += ($number_of_tags) * 2;
		}
	
		if (!empty($user)) {
			$current_message_length += strlen($user) + 5;
		}
	
		return $current_message_length;
	}
	
	public static function twitter_maximum_message_length($tweet, $url, $user, $hashtags) {
		$current_message_length = 0;
		$current_message_length += strlen($url) + 1;
		$current_message_length += strlen($hashtags);
		if (!empty($hashtags)) {
			$number_of_tags = substr_count($hashtags, ',');
			$number_of_tags++;
	
			$current_message_length += ($number_of_tags) * 2;
		}
	
		if (!empty($user)) {
			$current_message_length += strlen($user) + 5;
		}
	
		return 240 - $current_message_length;
	}
	
}