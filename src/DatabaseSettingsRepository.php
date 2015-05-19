<?php namespace QweB\Settings;

use Illuminate\Database\ConnectionInterface;

class DatabaseSettingsRepository implements SettingsRepositoryInterface {

	/**
	 * The database connection instance.
	 *
	 * @var \Illuminate\Database\ConnectionInterface
	 */
	protected $connection;

	/**
	 * The item database table.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Create a new item repository instance.
	 *
	 * @param  \Illuminate\Database\ConnectionInterface  $connection
	 * @param  string  $table
	 * @return void
	 */
	public function __construct(ConnectionInterface $connection, $table)
	{
		$this->table = $table;
		$this->connection = $connection;
	}

	/**
	 * Get the item record by name.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function retrieveByName($name)
	{
		$record = $this->getTable()->where(compact('name'))->first();

		return $record->serialized ? unserialize($record->value) : $record->value;
	}

	/**
	 * Create a new item record.
	 *
	 * @param  string $name
	 * @param  mixed $value
	 * @return void
	 */
	public function create($name, $value)
	{
		$this->getTable()->insert($this->getPayload($name, $value));
	}

	/**
	 * Update the given value by name.
	 *
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function update($name, $value)
	{
		$payload = $this->getPayload($name, $value);

		$this->getTable()->where(compact('name'))->update($payload);
	}

	/**
	 * Delete an existing item record by name.
	 *
	 * @param  string $name
	 * @return void
	 */
	public function delete($name)
	{
		$this->getTable()->where(compact('name'))->delete();
	}

	/**
	 * Determine if a item record exists.
	 *
	 * @param  string $name
	 * @return bool
	 */
	public function exists($name)
	{
		return ($this->retrieveByName($name) !== null);
	}

	/**
	 * Begin a new database query against the table.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	protected function getTable()
	{
		return $this->connection->table($this->table);
	}

	/**
	 * Get the payload for given attributes.
	 *
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return array
	 */
	protected function getPayload($name, $value)
	{
		$serialized = is_array($value) ? true : false;

		$value = is_array($value) ? serialize($value) : $value;

		return compact('name', 'value', 'serialized');
	}

}
