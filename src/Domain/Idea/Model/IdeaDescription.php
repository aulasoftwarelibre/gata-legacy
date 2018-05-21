<?php

declare(strict_types=1);

namespace App\Domain\Idea\Model;

use App\Domain\ValueObject;

final class IdeaDescription implements ValueObject
{
    /**
     * @var string
     */
    private $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function __toString(): string
    {
        return $this->description();
    }

    public function description(): string
    {
        return $this->description;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $this->description() === $valueObject->description();
    }
}