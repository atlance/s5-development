<?php

declare(strict_types=1);

namespace App\ReadModel;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Query\QueryBuilder;
use DomainException;

class Fetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Метод создан что бы выключать логер SQL запросов,
     * если они например длинные или в демоне - для блока утечки памяти.
     *
     * @param null $logger
     */
    public function setSQLLogger($logger = null) : self
    {
        try {
            $this->connection->getConfiguration()->setSQLLogger($logger);

            return  $this;
        } catch (\Throwable $exception) {
            throw new \DomainException('Configuration connection not defined.');
        }
    }

    /**
     * @param mixed      $arg2 if mode object - class name etc
     * @param array|null $arg3 if mode object - arguments on __constructor
     */
    protected function getResultStatement(
        QueryBuilder $queryBuilder,
        int $fetchMode,
        $arg2 = null,
        $arg3 = null
    ) : ResultStatement {
        $stmt = $queryBuilder->execute();
        if ($stmt instanceof ResultStatement) {
            $stmt->setFetchMode($fetchMode, $arg2, $arg3);

            return $stmt;
        }

        throw new DomainException('this method works only with the select operator');
    }

    protected function getQueryBuilder() : QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }
}
