<?php

declare(strict_types=1);

namespace App\Domain\Idea\Model;

use App\Domain\ValueObject;

final class IdeaTitle implements ValueObject
{
    /**
     * @var string
     */
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function __toString(): string
    {
        return $this->title();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $this->title() === $valueObject->title();
    }
}