<?php

class WPMDB_Sanitize {
	/**
	 * Sanitize and validate data.
	 *
	 * @param string|array $data      The data to the sanitized.
	 * @param string|array $key_rules The keys in the data (if data is an array) and the sanitization rule(s) to apply for each key.
	 * @param string       $context   Additional context data for messages etc.
	 *
	 * @return mixed The sanitized data, the data if no key rules supplied or `false` if an unrecognized rule supplied.
	 */
	static function sanitize_data( $data, $key_rules, $context ) {
		if ( empty( $data ) || empty( $key_rules ) ) {
			return $data;
		}

		return WPMDB_Sanitize::_sanitize_data( $data, $key_rules, $context );
	}

	/**
	 * Sanitize and validate data.
	 *
	 * @param string|array $data            The data to the sanitized.
	 * @param string|array $key_rules       The keys in the data (if data is an array) and the sanitization rule(s) to apply for each key.
	 * @param string       $context         Additional context data for messages etc.
	 * @param int          $recursion_level How deep in the recursion are we? Optional, defaults to 0.
	 *
	 * @return mixed The sanitized data, the data if no key rules supplied or `false` if an unrecognized rule supplied.
	 */
	private static function _sanitize_data( $data, $key_rules, $context, $recursion_level = 0 ) {
		if ( empty( $data ) || empty( $key_rules ) ) {
			return $data;
		}

		if ( 0 === $recursion_level && is_array( $data ) ) {
			// We always expect associative arrays.
			if ( ! is_array( $key_rules ) ) {
				wp_die( sprintf( __( '%1$s was not expecting data to be an array.', 'wp-db-migrate-pro' ), $context ) );

				return false;
			}
			foreach ( $data as $key => $value ) {
				// If a key does not have a rule it's not ours and can be removed.
				// We should not fail if there is extra data as plugins like Polylang add their own data to each ajax request.
				if ( ! array_key_exists( $key, $key_rules ) ) {
					unset( $data[ $key ] );
					continue;
				}
				$data[ $key ] = WPMDB_Sanitize::_sanitize_data( $value, $key_rules[ $key ], $context, ( $recursion_level + 1 ) );
			}
		} elseif ( is_array( $key_rules ) ) {
			foreach ( $key_rules as $rule ) {
				$data = WPMDB_Sanitize::_sanitize_data( $data, $rule, $context, ( $recursion_level + 1 ) );
			}
		} else {
			// Neither $data or $key_rules are a first level array so can be analysed.
			if ( 'array' == $key_rules ) {
				if ( ! is_array( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting an array but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'string' == $key_rules ) {
				if ( ! is_string( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting a string but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'key' == $key_rules ) {
				$key_name = sanitize_key( $data );
				if ( $key_name !== $data ) {
					wp_die( sprintf( __( '%1$s was expecting a valid key but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = $key_name;
			} elseif ( 'text' == $key_rules ) {
				$text = sanitize_text_field( $data );
				if ( $text !== $data ) {
					wp_die( sprintf( __( '%1$s was expecting text but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = $text;
			} elseif ( 'serialized' == $key_rules ) {
				if ( ! is_string( $data ) || ! is_serialized( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting serialized data but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'json_array' == $key_rules ) {
				if ( ! is_string( $data ) || ! WPMDB::is_json( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting JSON data but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = json_decode( $data, true );
			} elseif ( 'json' == $key_rules ) {
				if ( ! is_string( $data ) || ! WPMDB::is_json( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting JSON data but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'numeric' == $key_rules ) {
				if ( ! is_numeric( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting a valid numeric but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'int' == $key_rules ) {
				// As we are sanitizing form data, even integers are within a string.
				if ( ! is_numeric( $data ) || (int) $data != $data ) {
					wp_die( sprintf( __( '%1$s was expecting an integer but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = (int) $data;
			} elseif ( 'positive_int' == $key_rules ) {
				if ( ! is_numeric( $data ) || (int) $data != $data || 0 > $data ) {
					wp_die( sprintf( __( '%1$s was expecting a positive number (int) but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = floor( $data );
			} elseif ( 'negative_int' == $key_rules ) {
				if ( ! is_numeric( $data ) || (int) $data != $data || 0 < $data ) {
					wp_die( sprintf( __( '%1$s was expecting a negative number (int) but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = ceil( $data );
			} elseif ( 'zero_int' == $key_rules ) {
				if ( ! is_numeric( $data ) || (int) $data != $data || 0 !== $data ) {
					wp_die( sprintf( __( '%1$s was expecting 0 (int) but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = 0;
			} elseif ( 'empty' == $key_rules ) {
				if ( ! empty( $data ) ) {
					wp_die( sprintf( __( '%1$s was expecting an empty value but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
			} elseif ( 'url' == $key_rules ) {
				$url = esc_url_raw( $data );
				if ( empty( $url ) ) {
					wp_die( sprintf( __( '%1$s was expecting a URL but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = $url;
			} elseif ( 'bool' == $key_rules ) {
				$bool = sanitize_key( $data );
				if ( empty( $bool ) || ! in_array( $bool, array( 'true', 'false' ) ) ) {
					wp_die( sprintf( __( '%1$s was expecting a bool but got something else: "%2$s"', 'wp-db-migrate-pro' ), $context, $data ) );

					return false;
				}
				$data = $bool;
			} else {
				wp_die( sprintf( __( 'Unknown sanitization rule "%1$s" supplied by %2$s', 'wp-db-migrate-pro' ), $key_rules, $context ) );

				return false;
			}
		}

		return $data;
	}
}
