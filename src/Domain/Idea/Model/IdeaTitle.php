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

namespace AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\Gata\Domain\ValueObject;

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
        return $this->value();
    }

    public function value(): string
    {
        return $this->title;
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof self && $this->value() === $valueObject->value();
    }
}
