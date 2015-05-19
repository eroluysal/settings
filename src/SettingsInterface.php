<?php namespace QweB\Settings;

interface SettingsInterface {

	/**
	 * Retrieve an item from cache or database by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Create an item in the repository.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function put($key, $value);

	/**
	 * Remove an item from cache and database.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function delete($key);

}
