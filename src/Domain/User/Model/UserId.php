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

namespace App\Domain\User\Model;

use App\Domain\Exception\InvalidUuidFormatException;
use Ramsey\Uuid\Uuid;

class UserId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidUuidFormatException();
        }

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id();
    }

    public function equals(self $userId): bool
    {
        return $this->id() === $userId->id();
    }
}
