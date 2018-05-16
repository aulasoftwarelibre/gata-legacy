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

namespace App\Domain\Comment\Model;

use App\Domain\Comment\Exception\InvalidCommentIdFormatException;
use Ramsey\Uuid\Uuid;

class CommentId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidCommentIdFormatException();
        }

        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(self $commentId): bool
    {
        return $this->id() === $commentId->id();
    }
}
