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

namespace AulaSoftwareLibre\Gata\Infrastructure\Doctrine\EventStore;

use AulaSoftwareLibre\Gata\Application\Comment\Exception\CommentNotFoundException;
use AulaSoftwareLibre\Gata\Application\Comment\Repository\Comments;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\Comment;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Ramsey\Uuid\Uuid;

class CommentsEventStore extends AggregateRepository implements Comments
{
    public function save(Comment $comment): void
    {
        $this->saveAggregateRoot($comment);
    }

    public function get(CommentId $commentId): ?Comment
    {
        $comment = $this->getAggregateRoot($commentId->toString());

        if (!$comment instanceof Comment) {
            throw new CommentNotFoundException();
        }

        return $comment;
    }

    public function nextIdentity(): CommentId
    {
        return CommentId::fromString(Uuid::uuid4()->toString());
    }
}
