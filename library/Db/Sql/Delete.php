<?php
/**
 * Sphinx Search
 *
 * @link        https://github.com/ripaclub/sphinxsearch
 * @copyright   Copyright (c) 2014,
 *              Leo Di Donato <leodidonato at gmail dot com>,
 *              Leonardo Grasso <me at leonardograsso dot com>
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace SphinxSearch\Db\Sql;

use SphinxSearch\Db\Sql\Platform\ExpressionDecorator;
use Zend\Db\Adapter\Driver\DriverInterface;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql\Delete as ZendDelete;
use Zend\Db\Sql\ExpressionInterface;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Adapter\ParameterContainer;
use Zend\Version\Version;

// Polyfill for ZF from 2.1.x to 2.3.x
if (Version::compareVersion('2.4.0') > 0) {
    if (!class_exists('SphinxSearch\Db\Sql\Delete', true)) {
        require_once realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            'compatibility' . DIRECTORY_SEPARATOR . 'Delete.php'
        );
    }
    return;
}

/**
 * Class Delete
 */
class Delete extends ZendDelete
{
    /**
     * Create from statement
     *
     * @param  string|TableIdentifier $table
     * @return Delete
     */
    public function from($table)
    {
        if ($table instanceof TableIdentifier) {
            $table = $table->getTable(); // Ignore schema because it is not supported by SphinxQL
        }

        $this->table = $table;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function processExpression(
        ExpressionInterface $expression,
        PlatformInterface $platform,
        DriverInterface $driver = null,
        ParameterContainer $parameterContainer = null,
        $namedParameterPrefix = null
    ) {
        if ($expression instanceof ExpressionDecorator) {
            $expressionDecorator = $expression;
        } else {
            $expressionDecorator = new ExpressionDecorator($expression, $platform);
        }

        return parent::processExpression($expressionDecorator, $platform, $driver, $parameterContainer, $namedParameterPrefix);
    }
}