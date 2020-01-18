<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

use DateTime;
use DB;
use Exception;
use MeekroDBException;
use Monolog\Registry;

/**
 * Base Model Class
 *
 * This class is inherited by all Models to add DB Functionality
 * to the application Models.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Base
{
    protected $_fields = [];
    protected $_properties = [];
    protected $_modified = [];
    protected $_table_name = null;
    protected $_class_name = '';
    protected $logger = null;
    protected $skip_database;

    /**
     * Constructor
     * @codeCoverageIgnore
     */
    public function __construct($id = null)
    {
        if (getenv('NO_DB_CONNECTION')) {
            return;
        };

        // get the `potential` table name of the child object
        $this->loadProperties(strtolower(get_class($this)));
        $this->_class_name = get_class($this);

        // get logger instance
        $this->logger = Registry::getInstance('app');

        if ($id !== null) {
            $this->load((int)$id, false);
        }
    }

    /**
     * do not allow magic methods
     * @codeCoverageIgnore
     */
    public function __get(string $property_name)
    {
        $return_value = null;

        // only allow valid properties
        if (isset($this->_properties[$property_name])) {
            $return_value = $this->_properties[$property_name];
        } else {
            $error_message = 'Invalid property [get: ' . $this->_class_name .
                '] `' . $property_name . '`';
            $this->logger->error($error_message);
            throw new Exception($error_message);
        }

        return $return_value;
    }

    /**
     * do not allow magic methods
     * @codeCoverageIgnore
     * @throws Exception
     */
    public function __set(string $property_name, $value)
    {
        // only allow valid properties
        if (isset($this->_fields[$property_name])) {
            // preserve the `original` value of the field
            if (!isset($this->_modified[$property_name])) {
                if (isset($this->_properties[$property_name])) {
                    $this->_modified[$property_name] = $this->_properties[$property_name];
                } else {
                    $this->_modified[$property_name] = '';
                }
            }

            // store the new value
            $this->_properties[$property_name] = $value;
        } else {
            $error_message = 'Invalid property [set: ' . $this->_class_name .
                '] `' . $property_name . '`';
            $this->logger->error($error_message);
            throw new Exception($error_message);
        }
    }

    private function loadProperties(string $table_name): bool
    {
        // standardize the table name
        $table_name = trim(strtolower($table_name));

        // iterate over each column name, and add to properties list
        $found = false;
        try {
            $columns = DB::columnList($table_name);
            foreach ($columns as $column) {
                $this->_fields[$column] = true;
            }
            $this->_table_name = $table_name;
            $found = true;
        } catch (MeekroDBException $ex) {
            // we don't have a table...
            $this->_table_name = null;
        }

        return $found;
    }

    protected function getSignableData(): array
    {
        // get the properties, remove the actual signature for hashing
        $serializable_properties = $this->_properties;
        unset($serializable_properties['signature']);
        ksort($serializable_properties);

        return $serializable_properties;
    }

    protected function getSignature(): string
    {
        // return the signature of the data
        return hash('sha512', serialize($this->getSignableData()));
    }

    public function create(): bool
    {
        // store the last modified date (if it exists)
        if (isset($this->_fields['date_created'])) {
            $this->_properties['date_created'] = new DateTime('now');
        }

        // store the user who last modified the data (if it exists)
        if (isset($this->_fields['created_by'])) {
            $user_id = Auth::getLoggedInUserId();
            $this->_properties['created_by'] = $user_id;
        }

        // store record
        DB::insert($this->_table_name, [
            $this->_properties
        ]);

        // get created ID
        $id = DB::insertId();

        // read back the data to get defaults for integrity check
        $this->load($id, false);

        // create a signature based on the data with DB defaults
        if (isset($this->_fields['signature'])) {
            $this->_properties['signature'] = $this->getSignature();
        }

        // store record
        DB::update($this->_table_name, [
            $this->_properties
        ], 'id=%i', $id);

        return $id;
    }

    public function loadByField($field, $key): bool
    {
        if (isset($this->_properties[$field])) {

            if ($field == 'id') {
                if (!Validate::recordId($key)) {
                    return false;
                }
            }

            $id = DB::queryOneField($field, 'SELECT id FROM ' . $this->_table_name . ' WHERE %s=%s', $field, $key);
            $this->load($id);
        }

        return $id;
    }

    public function load(int $id, bool $checkIntegrity = true): bool
    {
        $success = false;

        if (!Validate::recordId($id)) {
            return false;
        }

        // load the record into the object
        $fields = DB::queryOneRow('SELECT * FROM ' . $this->_table_name . ' WHERE id=%i LIMIT 1;', $id);
        if (null !== $fields) {
            foreach ($fields as $field_name => $field) {
                $this->_properties[$field_name] = $field;
            }

            // default
            $fields['data_message'] = 'Data passed';
            $fields['data_integrity'] = true;

            // check record's signature to verify data, warn if something is wrong
            if ($checkIntegrity) {
                $calculatedSignature = $this->getSignature();
                if ($calculatedSignature !== $this->_properties['signature']) {
                    $message = 'Signature mismatch, possible data tampering.';
                    $this->logger->warning($message, [
                        'CalculatedSignature' => $calculatedSignature,
                        'StoredSignature' => $this->_properties['signature'],
                        'Fields' => $this->_properties,
                    ]);

                    // add data integrity warning messages
                    $fields['data_message'] = 'Data integrity violation';
                    $fields['data_integrity'] = false;
                }
            }

            $success = true;
        }

        // get status, and return t/f
        return $success;
    }

    public function save(): bool
    {
        // only save if something changed
        if (count($this->_modified)) {

            // store the last modified date (if it exists)
            if (isset($this->_fields['modified_date'])) {
                $this->_properties['date_modified'] = new DateTime('now');
            }

            // store the user who last modified the data (if it exists)
            if (isset($this->_fields['modified_by'])) {
                $user_id = 0;
                $user_id = Auth::getLoggedInUserId();
                $this->_properties['modified_by'] = $user_id;
            }

            // create a signature based on the data
            if (isset($this->_fields['signature'])) {
                $this->_properties['signature'] = $this->getSignature();
            }

            // update the record
            DB::update($this->_table_name,
                $this->_properties, 'id=%i', $this->_properties['id']
            );
        }

        // TODO: add auditing (what changed)

        // TODO: get status, and return t/f
        return true;
    }

    public function count(): int
    {
        // load the record into the object
        $fields = DB::queryOneRow('SELECT count(1) AS `total` FROM `' . $this->_table_name . '`');

        return (int)$fields['total'];
    }

    public function get($id)
    {
        // get all data records
        return DB::query('SELECT * FROM `' . $this->_table_name . '` WHERE `id`=%i', $id);
    }

    public function getAll($id = null)
    {
        if ($id !== null) {
            // get all data records
            return DB::query(
                'SELECT * FROM `' . $this->_table_name . '` WHERE `id`=%i', $id
            );
        }

        // get all data records
        return DB::query(
            'SELECT * FROM `' . $this->_table_name . '`'
        );
    }
}
