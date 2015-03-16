<?php
/**
 * Created by PhpStorm.
 * User: cmendoza
 * Date: 3/16/15
 * Time: 11:58 AM
 */

namespace cjmendoza\Cassandra;


class Cassandra{

    /**
     * @param array $nodes
     * @param array $options
     */
    public function connect(array $nodes, array $options = []) {
        return new Driver($nodes, '', $options);
    }

}