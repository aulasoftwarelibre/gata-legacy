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

namespace App\Infrastructure\ReadModel;

use Prooph\EventStore\Projection\ReadModel;

abstract class AbstractReadModel implements ReadModel
{
    /**
     * @var array
     */
    private $stack = [];
    /**
     * @var SchemaManagerInterface
     */
    private $schemaManager;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
    }

    public function init(): void
    {
        $this->schemaManager->init();
    }

    public function isInitialized(): bool
    {
        return $this->schemaManager->isInitialized();
    }

    public function reset(): void
    {
        $this->schemaManager->reset();
    }

    public function delete(): void
    {
        $this->schemaManager->delete();
    }

    public function stack(string $operation, ...$args): void
    {
        $this->stack[] = [$operation, $args];
    }

    public function persist(): void
    {
        foreach ($this->stack as list($operation, $args)) {
            $this->{$operation}(...$args);
        }

        $this->stack = [];
    }
}
