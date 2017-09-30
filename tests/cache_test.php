<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 1:54 PM
 */
class TestOfCacheObject extends UnitTestCase
{
    function __construct()
    {
        parent::__construct('Cache Test');
    }

    function testCreateAndReadCacheItem()
    {
        $key = '_cache_testing_123';
        $data = bin2hex(random_bytes(50));
        Cache::set($key, $data);
        $read_data = Cache::get($key);

        $this->assertEqual($data, $read_data);

    }

    function testReadCacheItemAndGetDefault()
    {
        $key = '_cache_testing_456';
        $read_data = Cache::get($key, 'default_value');

        $this->assertEqual('default_value', $read_data);
    }

    function testCreateAndReadCacheItemWithExpire()
    {
        // set test data
        $key = '_cache_testing_expired_555';
        $data = bin2hex(random_bytes(50));

        // save test data
        Cache::set($key, $data, 1);

        // immediately test for valid data
        $read_data = Cache::get($key);
        $this->assertEqual($data, $read_data);

        // expire data...
        sleep(2);
        $read_data = Cache::get($key);
        $this->assertEqual(null, $read_data);
    }

    function testCreateAndReadCacheItemWithExpireReturnDefault()
    {
        // set test data
        $key = '_cache_testing_expired_666';
        $data = bin2hex(random_bytes(50));

        // save test data
        Cache::set($key, $data, 1);

        // immediately test for valid data
        $read_data = Cache::get($key);
        $this->assertEqual($data, $read_data);

        // expire data...
        sleep(2);
        $read_data = Cache::get($key, 'default data');
        $this->assertEqual('default data', $read_data);
    }
}
