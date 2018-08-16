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

final class IdeaCapacity
{
    private $count;
    private $limit;

    public function __construct(?int $limit = null, int $count = 0)
    {
        if ($count < 0) {
            throw new \InvalidArgumentException('Count must be positive.');
        }

        if (null !== $limit && $limit < 1) {
            throw new \InvalidArgumentException('Limit must be null or greater than zero.');
        }

        if (null !== $limit && $limit < $count) {
            throw new \InvalidArgumentException('Count can not exceed limit.');
        }

        $this->count = $count;
        $this->limit = $limit;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function limit(): ?int
    {
        return $this->limit;
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

    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'count' => $this->count,
        ];
    }

    public function fromArray(array $data): IdeaCapacity
    {
        if (!isset($data['limit']) || !\is_int($data['limit'])) {
            throw new \InvalidArgumentException("Key 'limit' is missing in data array or is not an integer");
        }

        $limit = $data['limit'];

        if (!isset($data['count']) || !\is_int($data['count'])) {
            throw new \InvalidArgumentException("Key 'count' is missing in data array or is not an integer");
        }

        $count = $data['count'];

        return new self($limit, $count);
    }

    public function __toString(): string
    {
        return "{$this->count()}/{$this->limit()}";
    }

    public function equals(IdeaCapacity $ideaCapacity): bool
    {
        return $ideaCapacity instanceof self
            && $this->count() === $ideaCapacity->count()
            && $this->limit() === $ideaCapacity->limit()
        ;
    }
}
