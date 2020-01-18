<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SkeletonTest extends TestCase
{
    // protected $stack;
    // protected static $dbh;

    protected function setUp(): void
    {
        // $this->stack = [];
    }
    public static function setUpBeforeClass(): void
    {
        // self::$dbh = new PDO('sqlite::memory:');
    }

    public static function tearDownAfterClass(): void
    {
        // self::$dbh = null;
    }

    protected function assertPreConditions(): void
    {
    }

    public function testEmptyTest()
    {
    }
}
