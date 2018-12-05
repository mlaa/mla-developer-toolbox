<?php
/**
 * Created by PhpStorm.
 * User: jbetancourt
 * Date: 11/30/18
 * Time: 10:27 AM
 */

class MLA_UTILITIES {
	/**
	 * @param      $log
	 * @param bool $objArr
	 * @param bool $backtrace
	 */
	public static function write_log( $log, $backtrace = true, $debugOnly = true ) {
		if ( true == $debugOnly  &&  (! defined( 'WP_DEBUG' ) || false === WP_DEBUG) ) {
			return false;
		}

		$bk_msg    = $backtrace?self::backtrace():"";

		if ( is_array( $log ) || is_object( $log ) ) {
			if($backtrace) {
				error_log( $bk_msg . print_r( $log, true ) );
			}
			self::write_log( $log, false );
		} else {
			error_log( $bk_msg . $log );
		}
	}

	/**
	 * @return string
	 */
	public static function backtrace() {
		$backtrace = debug_backtrace();
		$bk_msg    = $backtrace[0]['file'] . "/" . $backtrace[0]['line'] . ": \n";
		if(!empty($backtrace[1])) {
			$bk_msg    .= $backtrace[1]['file'] . "/" . $backtrace[1]['line'] . ": \n";
		}
		return $bk_msg;
	}

	/**
	 * @param bool $msg
	 */
	static function lastSQL($msg = false)
	{
		global $wpdb;
		if($msg) {
			self::write_log($msg);
		}
		self::write_log($wpdb->last_query);
	}

}