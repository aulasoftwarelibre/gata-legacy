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

namespace AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\Gata\Domain\Idea\Exception\ExceededCapacityLimitException;
use AulaSoftwareLibre\Gata\Domain\Idea\Exception\InvalidIdeaCapacityException;
use AulaSoftwareLibre\Gata\Domain\ValueObject;

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

    public function __construct(?int $limit = null, int $count = 0)
    {
        if ($count < 0) {
            throw new InvalidIdeaCapacityException();
        }

        if (null !== $limit && $limit < 1) {
            throw new InvalidIdeaCapacityException();
        }

        if (null !== $limit && $limit < $count) {
            throw new ExceededCapacityLimitException();
        }

        $this->count = $count;
        $this->limit = $limit;
    }

    public function increment(): self
    {
        return new IdeaCapacity($this->limit, $this->count + 1);
    }

    public function decrement(): self
    {
        return new IdeaCapacity($this->limit, $this->count - 1);
    }

    public function unlimited(): self
    {
        return new IdeaCapacity(null, $this->count());
    }

    public function limited(int $limit): self
    {
        return new IdeaCapacity($limit, $this->count());
    }

    public function __toString(): string
    {
        return "{$this->count()}/{$this->limit()}";
    }

    public function count(): int
    {
        return $this->count;
    }

    public function limit(): ?int
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
