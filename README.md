PHP library for Cassandra
=========================

[![Build Status](https://travis-ci.org/LarsFronius/php-cassandra-binary.svg?branch=master)](https://travis-ci.org/LarsFronius/php-cassandra-binary)
<a href="https://codeclimate.com/github/cjmendoza/php-cassandra-binary"><img src="https://codeclimate.com/github/cjmendoza/php-cassandra-binary.png" /></a>
<a href="https://scrutinizer-ci.com/g/cjmendoza/php-cassandra-binary/"><img src="https://scrutinizer-ci.com/g/cjmendoza/php-cassandra-binary/badges/quality-score.png?b=master" /></a>
<a href="https://scrutinizer-ci.com/g/cjmendoza/php-cassandra-binary/"><img src="https://scrutinizer-ci.com/g/cjmendoza/php-cassandra-binary/badges/build.png?b=master" /></a>


Cassandra client library for PHP, using the native binary protocol.

## Known issues
* decimal and timestamps have bugs especially in collections (map,set,list)
* connection handling e.g. timeouts

## Installation

PHP 5.4+ is required. There is no need for additional libraries.

Append dependency into composer.json

```
	...
	"require": {
		...
		"cjmendoza/php-cassandra-binary": "dev-master"
	}
	...
```

## Example use

```php
<?php

use cjmendoza/Cassandra/Cassandra

$nodes = [
	'127.0.0.1',
	'192.168.0.2:8882' => [
		'username' => 'admin',
		'password' => 'pass'
	]
];

// Connect to database.
$cluster = Cassandra::connect($nodes);
$db_driver = $cluster->connect(<keyspace>);

// Run query.
$users = $db_driver->execute('SELECT * FROM "users" WHERE "id" = :id', ['id' => 'c5420d81-499e-4c9c-ac0c-fa6ba3ebc2bc']);

var_dump($users);
/*
	result:
		array(
			[0] => array(
				'id' => 'c5420d81-499e-4c9c-ac0c-fa6ba3ebc2bc',
				'name' => 'userName',
				'email' => 'user@email.com'
			)
		)
*/

// Keyspace can be changed at runtime
$db_driver->setKeyspace('my_other_keyspace');
// Get from other keyspace
$urlsFromFacebook = $db_driver->execute('SELECT * FROM "urls" WHERE "host" = :host', ['host' => 'facebook.com']);

```

## Using transaction

```php
	$db_driver->beginBatch();
	// all INSERT, UPDATE, DELETE query append into batch query stack for execution after applyBatch
	$uuid = $database->query('SELECT uuid() as "uuid" FROM system.schema_keyspaces LIMIT 1;')[0]['uuid'];
	$db_driver->execute(
			'INSERT INTO "users" ("id", "name", "email") VALUES (:id, :name, :email);',
			[
				'id' => $uuid,
				'name' => 'Mark',
				'email' => 'mark@facebook.com'
			]
		);

	$db_driver->execute(
			'DELETE FROM "users" WHERE "email" = :email;',
			[
				'email' => 'durov@vk.com'
			]
		);
	$result = $db_driver->applyBatch();
```

## Supported datatypes

All types are supported.

* *ascii, varchar, text*
  Result will be a string.
* *bigint, counter, varint*
  Converted to strings using bcmath.
* *blob*
  Result will be a string.
* *boolean*
  Result will be a boolean as well.
* *decimal*
  Converted to strings using bcmath.
* *double, float, int*
  Result is using native PHP datatypes.
* *timestamp*
  Converted to integer. Milliseconds precision is lost.
* *uuid, timeuuid, inet*
  No native PHP datatype available. Converted to strings.
* *list, set*
  Converted to array (numeric keys).
* *map*
  Converted to keyed array.
