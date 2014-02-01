Sphinx Search [![License](http://img.shields.io/badge/license-BSD--2-green.svg)](http://opensource.org/licenses/BSD-2-Clause)&nbsp;[![Build Status](http://img.shields.io/travis/ripaclub/sphinxsearch/develop.svg)](https://travis-ci.org/ripaclub/sphinxsearch.png?branch=develop)&nbsp;[![Latest Stable Version](https://poser.pugx.org/ripaclub/sphinxsearch/v/stable.png)](https://packagist.org/packages/ripaclub/sphinxsearch)
=============

Sphinx Search library provides SphinxQL indexing and searching features.

Introduction
---

This Library aims to provide:

 - A `SphinxQL` query builder based upon [Zend\Db\Sql](http://framework.zend.com/manual/2.2/en/modules/zend.db.sql.html)
 - A simple `Search` class
 - An `Indexer` class to work with RT indices
 - Factories for `SphinxQL` connection through [Zend\Db\Adapter](http://framework.zend.com/manual/2.2/en/modules/zend.db.adapter.html)

###### Note

This library does not use `SphinxClient` PHP extension because everything available through the Sphinx API is also available via `SphinxQL` but not vice versa (i.e., writing to RT indicies is only available via `SphinxQL`).

Installation
---

Using [composer](http://getcomposer.org/):

Add the following to your `composer.json` file:

    "require": {
        "php": ">=5.3.3",
        "ripaclub/sphinxsearch": "~0.2.0",
    }

Alternately with git submodules:

    git submodule add https://github.com/ripaclub/sphinxsearch.git ripaclub/sphinxsearch


Configuration
---

Register in the `ServiceManager` the provided factories through the `service_manager` configuration node:

    'service_manager' => array(

        'factories' => array(
          'SphinxSearch\Db\Adapter\Adapter' => 'SphinxSearch\Db\Adapter\AdapterServiceFactory',
        ),

        // Alternately register the abstract facory
        'abstract_factories' => array(
          'SphinxSearch\Db\Adapter\AdapterAbstractServiceFactory'
        ),

        // Optionally
        'aliases' => array(
          'sphinxql' => 'SphinxSearch\Db\Adapter\Adapter'
        ),

    )

Then in your configuration add the `sphinxql` node and configure it with connection parameters via `Pdo` driver. Configuration parameters will be used by `Zend\Db\Adapter\Adapter` (refer to its documentation for details).

Example:

    'sphinxql' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=dummy;host=127.0.0.1;port=9306;',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    )

If you use the abstract factory refer to [Zend Db Adpater Abstract Factory documentation](http://framework.zend.com/manual/2.2/en/modules/zend.mvc.services.html#zend-db-adapter-adapterabstractservicefactory)

Using
---

Two driver are supported.

- PDO (MySQL only)
- Mysqli

Testing
---

Once installed development dependencies through composer you can run `phpunit`.

```{bash}
./vendor/bin/phpunit -c tests/
```

