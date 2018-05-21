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

namespace App\Domain\Group\Model;

use App\Domain\Group\Exception\EmptyGroupNameException;
use App\Domain\ValueObject;

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

    public function __toString()
    {
        return $this->name();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $valueObject->name() === $this->name();
    }
}
