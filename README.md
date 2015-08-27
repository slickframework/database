# Slick Database package

[![Latest Version](https://img.shields.io/github/release/slickframework/database.svg?style=flat-square)](https://github.com/slickframework/database/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/slickframework/database/develop.svg?style=flat-square)](https://travis-ci.org/slickframework/database)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/slickframework/database/develop.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/database/code-structure?branch=develop)
[![Quality Score](https://img.shields.io/scrutinizer/g/slickframework/database/develop.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/database?branch=develop)
[![Total Downloads](https://img.shields.io/packagist/dt/slick/database.svg?style=flat-square)](https://packagist.org/packages/slick/database)

Database adapter is a vary powerful, yet lightweight object that allows you to
connect to database drivers and abstracts all the iteration you regularly need
when working with databases.

`Slick\Common\Database` has drivers for MySql and Sqlite out of the box but it
also has a very simple interface you can use to implement you own driver. It
has a separate interface for drivers of database systems that support
transactions.

This package is extracted from [Slick framework](https://github.com/slickframework/slick).

This package is compliant with PSR-2 code standards and PSR-4 autoload standards. It
also applies the [semantic version 2.0.0](http://semver.org) specification.

## Install

Via Composer

``` bash
$ composer require slick/common
```

## Usage

The best way to create a database adapter is using the `Slick\Database\Adapter`
factory.

Lets create an adapter for MySql database server:

```php
use Slick\Database\Adapter;

$adapter = Adapter::create(
    [
        'driver'  => Adapter::DRIVER_MYSQL,
        'options' => [
            'database' => 'tests',
            'username' => 'user',
            'password' => '********'
            'host'     => 'localhost'
        ]
    ]
);
```

And that's it! The code above will create a `Slick\Database\MysqlAdapter`
adapter that you can use to run your queries.

This are the options for known drivers

---
MySql adapter driver name: `Slick\Database\MysqlAdapter::DRIVER_MYSQL`
 
| *Property* | *Default* | *Description*                                    |
|------------|-----------|--------------------------------------------------|
| `host`     | null      | The server host name
| `port`     | 3306      | The server port
| `username` | null      | User with access to tah server
| `password` | null      | User correspondent password
| `database` | null      | The database name
| `charset`  | 'utf8'    | The encoding charset

---
Sqlite adapter driver name: `Slick\Database\MysqlAdapter::DRIVER_SQLITE`
 
| *Property* | *Default*  | *Description*                                    |
|------------|------------|--------------------------------------------------|
| `file`     | ':memory:' | The path to the database file

<div class="alert alert-warning" role="alert">
    <h4>
        <i class="fa fa-exclamation "></i>
        Careful
    </h4>
    
    As a limitation of Sqlite the <code>Slick\Database\Adapter\SqliteAdapter</code>
    does not support transactions. As so you should check if the adapter you
    are working with implements <code>Slick\Database\Adapter\TransactionsAwareInterface</code>
    before you use <code>beginTransaction()</code>, <code>commit()</code>
    and <code>rollBack()</code> methods. 
</div>

<div id="query"></div>

## Querying data

---

Once you now have a database adapter it is very simple to retrieve data from a database
server.

```php

$sql = "SELECT * FROM users";

$data = $adapter->query($sql);

print_r($data[0]);

# This will output
Array (
    'id' => 1,
    'name' => 'Jon Doe',
    ...
)

```

The output form a query is always a `Slick\Database\RecordList` object. This object
implements `Countable`, `ArrayAccess` and `IteratorAggregate` so it can be used as
an array or you can iterate over the records that the query operation has returned.

If you want to use the raw array returned from query you can call the
`Slick\Database\RecordList::asArray()` method.

If in result of the query operation you got an empty record list you will have
`Slick\Database\RecordList::count()` returning a 0 (zero) count.

### Binding parameters to your queries

---

The implementations that we have made for MySql and Sqlite adapters are, more or
less, proxies for the PHP PDO and PDOStatement objects. This means that we can
bind parameters to SQL query in form of placeholders.

So if you want to do a query with parameters just do something similar
to the follow:

```php
$sql = 'SELECT name, colour, calories
        FROM fruit
        WHERE calories < ? AND colour = ?';

$red = $adapter->query($sql, [150, 'red']);
```

Every time a query is made a prepared statement is created and the passed parameters
are bind to the query upon query execution.

For a full documentation on this package please visit
[Slick Documentation Site](https://www.slick-framework.com/packages/database).

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email silvam.filipe@gmail.com instead of using the issue tracker.

## Credits

- [Slick framework](https://github.com/slickframework)
- [All Contributors](https://github.com/slickframework/database/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.