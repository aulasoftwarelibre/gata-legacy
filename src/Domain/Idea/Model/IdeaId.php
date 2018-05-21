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

use App\Domain\Idea\Exception\InvalidIdeaIdFormatException;
use App\Domain\ValueObject;
use Ramsey\Uuid\Uuid;

final class IdeaId implements ValueObject
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidIdeaIdFormatException();
        }

        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $this->id() === $valueObject->id();
    }
}
