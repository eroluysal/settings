<?php

use Mockery as m;
use QweB\Settings\DatabaseSettingsRepository as DbSettingsRepository;

class DatabaseSettingsRepositoryTest extends PHPUnit_Framework_TestCase {

    public function testResolving()
    {
        $connection = m::mock('Illuminate\Database\ConnectionInterface');
        $connection->shouldReceive('table')->andReturn($connection);
        $connection->shouldReceive('insert')->andReturn(null);

        $settings = new DbSettingsRepository($connection, 'foo');
        $settings->create('foo', 'bar');
    }

    public function testGetValueWhenExistingAndStringValue()
    {
        $connection = m::mock('Illuminate\Database\ConnectionInterface');
        $connection->shouldReceive('table')->andReturn($connection);
        $connection->shouldReceive('where')->andReturn($connection);
        $connection->shouldReceive('first')->andReturn($m = m::mock('stdClass'));
        $m->value = 'bar';
        $m->serialized = false;

        $settings = new DbSettingsRepository($connection, 'foo');
        $this->assertEquals($settings->retrieveByName('foo'), 'bar');
    }

    public function testGetValueWhenExistingAndSerializedValue()
    {
        $connection = m::mock('Illuminate\Database\ConnectionInterface');
        $connection->shouldReceive('table')->andReturn($connection);
        $connection->shouldReceive('where')->andReturn($connection);
        $connection->shouldReceive('first')->andReturn($m = m::mock('stdClass'));
        $m->value = serialize(['foo' => 'bar']);
        $m->serialized = true;

        $settings = new DbSettingsRepository($connection, 'foo');
        $this->assertEquals($settings->retrieveByName('foo'), ['foo' => 'bar']);
    }

}