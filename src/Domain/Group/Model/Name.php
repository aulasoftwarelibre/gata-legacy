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

use App\Domain\Group\Exception\EmptyNameException;
use App\Domain\ValueObject;

class Name implements ValueObject
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new EmptyNameException();
        }

        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    public function equals(ValueObject $object): bool
    {
        return $object instanceof self && $object->value() === $this->value();
    }
}
