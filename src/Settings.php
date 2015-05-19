<?php namespace QweB\Settings;

use Exception;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use QweB\Settings\SettingsRepositoryInterface as DbItemRepository;

class Settings implements SettingsInterface {

	/**
	 * The items repository instance.
	 *
	 * @var \QweB\Settings\SettingsRepositoryInterface
	 */
	protected $items;

	/**
	 * The Cache implementation.
	 *
	 * @var \Illuminate\Contracts\Cache\Repository
	 */
	protected $cache;

	/**
	 * Create a new Settings instance.
	 *
	 * @param  \QweB\Settings\SettingsRepositoryInterface  $items
	 * @param  \Illuminate\Contracts\Cache\Repository  $cache
	 * @return void
	 */
	public function __construct(DbItemRepository $items, CacheContract $cache)
	{
		$this->items = $items;
		$this->cache = $cache;
	}

	/**
	 * Retrieve an item from cache or database by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key)
	{
		return $this->cache->rememberForever($key, function() use ($key)
		{
			return $this->items->retrieveByName($key);
		});
	}

	/**
	 * Create an item in the repository.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function put($key, $value)
	{
		try
		{
			$this->items->create($key, $value);
		}
		catch (Exception $e)
		{
			$this->items->update($key, $value);
		}

		$this->cache->forget($key);
	}

	/**
	 * Remove an item from cache and database.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function delete($key)
	{
		$this->items->delete($key);

		$this->cache->forget($key);
	}

}
