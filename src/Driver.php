<?php
/**
 * Created by PhpStorm.
 * User: cmendoza
 * Date: 3/16/15
 * Time: 3:07 PM
 */

namespace cjmendoza\Cassandra;


use evseevnn\Cassandra\Database;
use evseevnn\Cassandra\Cluster;
use evseevnn\Cassandra\Enum\ConsistencyEnum;
use evseevnn\Cassandra\Exception\CassandraException;
use evseevnn\Cassandra\Exception\QueryException;
use evseevnn\Cassandra\Exception\ConnectionException;

class Driver extends Database{

    /**
     * Connect to database
     * @throws ConnectionException
     * @throws CassandraException
     * @return bool
     */
    public function connect($keyspace) {
        $this->keyspace = $keyspace;
        parent::connect();
        return $this;
    }

    /**
     * Test connection to database
     * @return bool
     */
    public function isConnected() {
        return $this->connection->isConnected();
    }

    /**
     * Send query into database
     * @param string $cql
     * @param array $values
     * @param int $consistency
     * @throws QueryException
     * @throws CassandraException
     * @return array|null
     */
    public function execute($cql, array $values = [], $consistency = ConsistencyEnum::CONSISTENCY_QUORUM)
    {
        $this->query($cql, $values , $consistency);
    }

}