<?php

// this file is auto-generated by prolic/fpp
// don't edit this file manually

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

final class IdeaId
{
    private $uuid;

    public static function generate(): IdeaId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $ideaId): IdeaId
    {
        return new self(\Ramsey\Uuid\Uuid::fromString($ideaId));
    }

    private function __construct(\Ramsey\Uuid\UuidInterface $ideaId)
    {
        $this->uuid = $ideaId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(IdeaId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
