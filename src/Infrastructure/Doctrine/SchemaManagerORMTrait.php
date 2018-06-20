<?php

declare(strict_types=1);

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Doctrine;

use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Tools\SchemaTool;

trait SchemaManagerORMTrait
{
    public function init(): void
    {
        $schemaTool = new SchemaTool($this->_em);
        $classMetadata = $this->getClassMetadata();

        $schemaTool->createSchema([$classMetadata]);
    }

    public function isInitialized(): bool
    {
        $tableName = $this->getClassMetadata()->getTableName();
        $tables = $this->_em->getConnection()->getSchemaManager()->listTables();

        return !empty(
            array_filter($tables, function (Table $table) use ($tableName) {
                return $table->getName() === $tableName;
            })
        );
    }

    public function reset(): void
    {
        $this->createQueryBuilder('o')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function delete(): void
    {
        $schemaTool = new SchemaTool($this->_em);
        $schemaTool->dropSchema([$this->getClassMetadata()]);
    }
}
