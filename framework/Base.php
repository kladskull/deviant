<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 1:00 PM
 */
class Base
{
    protected $_fields = [];
    protected $_properties = [];
    protected $_modified = [];
    protected $_table_name = null;
    protected $_class_name = '';
    protected $logger = null;

    // constructor
    public function __construct()
    {
        // get the `potential` table name of the child object
        $this->loadProperties(strtolower(get_class($this)));
        $this->_class_name = get_class($this);

        // get logger instance
        $this->logger = Monolog\Registry::getInstance('app');
    }

    // do not allow magic methods
    public function __get(string $property_name)
    {
        $return_value = null;

        // only allow valid properties
        if (isset($this->_properties[$property_name])) {
            $return_value = $this->_properties[$property_name];
        } else {
            $error_message = 'Invalid property [get: ' . $this->_class_name .
                '] `' . $property_name . '`';
            throw new Exception($error_message);
        }

        return $return_value;
    }

    // do not allow magic methods
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

    protected function getSignature(): string
    {
        // update the signature
        return hash('sha512', serialize($this->_properties));
    }

    public function create(): bool
    {
        // create a signature based on the data
        if (isset($this->_fields['signature'])) {
            $this->_properties['signature'] = $this->getSignature();
        }

        // store the last modified date (if it exists)
        if (isset($this->_fields['date_created'])) {
            $this->_properties['date_created'] = new DateTime('now');
        }

        // store the user who last modified the data (if it exists)
        if (isset($this->_fields['created_by'])) {
            $user_id = 0;
            if (!empty($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            }
            $this->_properties['created_by'] = $user_id;
        }

        // only save if something changed
        DB::insert('user', [
            $this->_properties
        ]);

        // TODO: get status, and return t/f
        return true;
    }

    public function loadByField($field, $key)
    {
        $success = false;
        if (isset($this->_properties[$field])) {

            $id = DB::queryOneField($field, 'SELECT id FROM ' . $this->_table_name . ' WHERE %s=%s', $field, $key);

            $success = true;
        }

        return $success;
    }

    public function load(int $id): bool
    {
        // load the record into the object
        $fields = DB::queryOneRow('SELECT * FROM ' . $this->_table_name . ' WHERE id=%i LIMIT 1;', $id);
        foreach ($fields as $field_name => $field) {
            $this->_properties[$field_name] = $field;
        }

        // TODO: check record signature to the data, warn if something is wrong

        // TODO: get status, and return t/f
        return true;
    }

    public function save(): bool
    {
        // only save if something changed
        if (count($this->_modified)) {

            // create a signature based on the data
            if (isset($this->_fields['signature'])) {
                $this->_properties['signature'] = $this->getSignature();
            }

            // store the last modified date (if it exists)
            if (isset($this->_fields['modified_date'])) {
                $this->_properties['date_modified'] = new DateTime('now');
            }

            // store the user who last modified the data (if it exists)
            if (isset($this->_fields['modified_by'])) {
                $user_id = 0;
                if (!empty($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                }
                $this->_properties['modified_by'] = $user_id;
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

        return $fields['total'];
    }

    public function getAll()
    {
        // get all user records
        return DB::query('SELECT * FROM `' . $this->_table_name . '`');
    }

}
