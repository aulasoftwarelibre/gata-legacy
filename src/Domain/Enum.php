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

namespace App\Domain;

use MabeEnum\Enum as BaseEnum;
use MabeEnum\EnumSerializableTrait;
use Serializable;

abstract class Enum extends BaseEnum implements Serializable, ValueObject
{
    use EnumSerializableTrait;

    public function equals(ValueObject $object): bool
    {
        return $this->is($object);
    }
}
