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

namespace AulaSoftwareLibre\Gata\Domain\Comment\Model;

final class CommentId
{
    private $uuid;

    public static function generate(): CommentId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $commentId): CommentId
    {
        return new self(\Ramsey\Uuid\Uuid::fromString($commentId));
    }

    private function __construct(\Ramsey\Uuid\UuidInterface $commentId)
    {
        $this->uuid = $commentId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(CommentId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
