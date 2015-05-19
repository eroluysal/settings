<?php

use Mockery as m;
use QweB\Settings\Settings;

class SettingsTest extends PHPUnit_Framework_TestCase {

    public function testPutSettingsToDatabaseAndSetCacheDatabase()
    {
        $repository = m::mock('QweB\Settings\SettingsRepositoryInterface');
		$repository->shouldReceive('update')->andReturn($repository);

        $cache = m::mock('Illuminate\Contracts\Cache\Repository');
        $cache->shouldReceive('rememberForever')->andReturn($cache);
		$cache->shouldReceive('forget')->andReturn($cache);

        $settings = new Settings($repository, $cache);
        $settings->put('foo', 'bar');
    }

    public function testGetValueFromCacheOrDatabase()
    {
        $repository = m::mock('QweB\Settings\SettingsRepositoryInterface');

        $cache = m::mock('Illuminate\Contracts\Cache\Repository');
        $cache->shouldReceive('rememberForever')->andReturn('bar');
        $cache->shouldReceive('get')->andReturn('bar');

        $settings = new Settings($repository, $cache);
        $this->assertEquals($settings->get('foo'), 'bar');
    }

    public function testDeleteValueFromCacheOrDatabase()
    {
        $repository = m::mock('QweB\Settings\SettingsRepositoryInterface');
        $repository->shouldReceive('delete')->andReturn(null);

        $cache = m::mock('Illuminate\Contracts\Cache\Repository');
        $cache->shouldReceive('forget')->andReturn(null);

        $settings = new Settings($repository, $cache);
        $settings->delete('foo');
    }

}
