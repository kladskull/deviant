<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 1:02 PM
 */
class User extends Base
{
    /**
     * The names of the attributes that cannot be edited
     * externally after creation.
     *
     * @var array
     */
    protected $immutable_fields = [
        'id',
        'password',
        'user_guid',
        'date_created',
        'created_by',
        'date_modified',
        'modified_by',
        'signature',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public
    static function emailExists(string $email): bool
    {
        if (Validate::emailAddress($email)) {
            // get the user record
            $record = DB::queryFirstRow('SELECT `email_address` FROM `users` WHERE `email_address`=%s LIMIT 1;', $email);
            if ($record !== null) {
                return true;
            }
        }
        return false;
    }

    public static function getUserList()
    {
        // get all user records
        return DB::query('SELECT `id`,`email_address`,`locked`,`admin` FROM `user`');
    }
}
