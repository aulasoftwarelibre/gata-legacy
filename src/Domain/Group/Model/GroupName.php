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

namespace AulaSoftwareLibre\Gata\Domain\Group\Model;

use AulaSoftwareLibre\Gata\Domain\Group\Exception\EmptyGroupNameException;
use AulaSoftwareLibre\Gata\Domain\ValueObject;

final class GroupName implements ValueObject
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        if ('' === $name) {
            throw new EmptyGroupNameException();
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->name;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $valueObject->value() === $this->value();
    }
}
