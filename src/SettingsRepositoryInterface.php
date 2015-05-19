<?php namespace QweB\Settings;

interface SettingsRepositoryInterface {

	/**
	 * Get the item record by name.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function retrieveByName($name);

	/**
	 * Create a new item record.
	 *
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function create($name, $value);

	/**
	 * Update the given value by name.
	 *
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function update($name, $value);

	/**
	 * Delete an existing item record by name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function delete($name);

	/**
	 * Determine if a item record exists.
	 *
	 * @param  string  $name
	 * @return bool
	 */
	public function exists($name);

}
