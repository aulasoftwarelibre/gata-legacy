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

namespace App\Domain\Idea\Model;

use App\Domain\ValueObject;

final class IdeaCapacity implements ValueObject
{
    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $limit;

    public function __construct(int $count, int $limit)
    {
        $this->count = $count;
        $this->limit = $limit;
    }

    public function __toString(): string
    {
        return "{$this->count()}/{$this->limit()}";
    }

    public function count(): int
    {
        return $this->count;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self
            && $this->count() === $valueObject->count()
            && $this->limit() === $valueObject->limit()
        ;
    }
}
