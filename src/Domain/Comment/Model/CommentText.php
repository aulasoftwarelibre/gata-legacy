<?php

declare(strict_types=1);

namespace App\Domain\Comment\Model;

use App\Domain\Comment\Exception\EmptyCommentTextException;
use App\Domain\ValueObject;

final class CommentText implements ValueObject
{
    /**
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        if ('' === $text) {
            throw new EmptyCommentTextException();
        }

        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text();
    }

    public function text(): string
    {
        return $this->text;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $this->text() === $valueObject->text();
    }
}