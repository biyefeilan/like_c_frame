<?php

final class _C_Util {
	
	/**
	 * stripslashes
	 * @param string or array $value
	 * @return string or array
	 */
	public static function stripslashes(&$value) {
		if (is_array ( $value )) {
			foreach ( $value as $k => $v ) {
				$value [$k] = self::stripslashes ( $v );
			}
		} else {
			$value = stripslashes ( $value );
		}
		return $value;
	}
	
	public static function trim(&$value) {
		if (is_array ( $value )) {
			array_walk_recursive ( $value, array ('_C_Util', 'trim' ) );
		} else
			$value = trim ( str_replace ( "\r\n", "\n", $value ) );
	}
	
	public static function flush()
	{
		echo(str_repeat(' ',256));
		if (ob_get_length())
		{
			@ob_flush();
			@flush();
			@ob_end_flush();
		}
		@ob_start();
	}
}

?>