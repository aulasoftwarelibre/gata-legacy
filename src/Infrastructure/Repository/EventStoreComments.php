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

namespace App\Infrastructure\Repository;

use App\Application\Comment\Exception\CommentNotFoundException;
use App\Application\Comment\Repository\Comments;
use App\Domain\Comment\Model\Comment;
use App\Domain\Comment\Model\CommentId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Ramsey\Uuid\Uuid;

class EventStoreComments extends AggregateRepository implements Comments
{
    public function save(Comment $comment): void
    {
        $this->saveAggregateRoot($comment);
    }

    public function get(CommentId $commentId): ?Comment
    {
        $comment = $this->getAggregateRoot($commentId->value());

        if (!$comment instanceof Comment) {
            throw new CommentNotFoundException();
        }

        return $comment;
    }

    public function nextIdentity(): CommentId
    {
        return new CommentId(Uuid::uuid4()->toString());
    }
}
