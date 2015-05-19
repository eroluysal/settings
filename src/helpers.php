<?php

if ( ! function_exists('settings'))
{
	/**
	 * Get / set the specified configuration value.
	 *
	 * @param  string|array  $key
	 * @param  string        $value
	 * @return mixed
	 */
	function settings($key, $value = null)
	{
		if ( ! is_null($value))
		{
			app('settings')->put($key, $value);
		}

		return app('settings')->get($key);
	}
}
