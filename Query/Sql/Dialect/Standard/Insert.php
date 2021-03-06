<?php

/**
 * Insert
 * 
 * @package   Slick\Database\Query\Sql\Dialect\Standard
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 Filipe Silva
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\Database\Query\Sql\Dialect\Standard;

use Slick\Common\Base;

/**
 * Insert
 *
 * @package   Slick\Database\Query\Sql\Dialect\Standard
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class Insert extends Base
{
    /**
     * @readwrite
     * @var \Slick\Database\Query\SqlInterface
     */
    protected $_sql;

    /**
     * @var string The query template
     */
    protected $_insert = <<<EOT
INSERT INTO %s (%s)
VALUES (%s)
EOT;

    /**
     * Returns the SQL query string for current Select SQL Object
     * 
     * @return String The SQL query string
     */
    public function getStatement()
    {
        return trim(
            sprintf(
                $this->_insert,
                $this->_sql->getTableName(),
                $this->getColumns(),
                $this->getValues()
            )
        );
    }

    /**
     * Returns a string containing the field names seperated by commas
     * 
     * @return string The field list as string
     */
    public function getColumns()
    {
        $names = array_keys($this->_sql->getFieldNames());
        return implode(', ', $names);
    }

    /**
     * Returns a string containing the placeholders for query execute
     * 
     * @return string The placeholders for query execute
     */
    public function getValues()
    {
        $keys = $this->_sql->getFieldNames();
        return implode(', ', $keys);
    }
}