<?php declare(strict_types=1); // strict mode

namespace Deviant\Models;

use DB;
use Deviant\Framework\Base;
use Deviant\Framework\Validate;

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 1:02 PM
 */
class Api extends Base
{
    /**
     * The names of the attributes that cannot be edited
     * externally after creation.
     *
     * @var array
     */
    protected $immutable_fields = [
        'id',
        'record_guid',
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


    public static function getAllUsersKeys(int $userId)
    {
        if (!Validate::recordId($userId)) {
            return null;
        }

        // TODO: get rid of the *
        return DB::query('SELECT `id`,`description`,`access_id`,`date_created`,`last_used`,`Locked` FROM `api` WHERE user_id=%i;',
            $userId);
    }
}
