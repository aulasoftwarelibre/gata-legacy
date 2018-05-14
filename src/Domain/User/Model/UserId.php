<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\User\Exception\InvalidUuidFormatException;
use Ramsey\Uuid\Uuid;

class UserId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        if (! Uuid::isValid($id)) {
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

    public function equals(UserId $userId): bool
    {
        return $this->id() === $userId->id();
    }
}
