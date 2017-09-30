<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 1:54 PM
 */
class TestOfUserObject extends UnitTestCase
{
    function __construct()
    {
        parent::__construct('User Test');
    }

    function testCreateBareObject()
    {
        echo 'Create bare object',PHP_EOL;
        $user = new User();
        $this->assertTrue($user instanceof User);
    }

    function testLoadUser()
    {
        echo 'Load User',PHP_EOL;
        $user = new User();
        $user->load(1);
    }

    function testModifyUser()
    {
        echo 'Modify User',PHP_EOL;
        $user = new User();
        $user->load(1);

        $user->first_name = 'Mike';
        $user->save();
    }
}
