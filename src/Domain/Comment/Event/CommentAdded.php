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

namespace AulaSoftwareLibre\Gata\Domain\Comment\Event;

use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use Prooph\EventSourcing\AggregateChanged;

final class CommentAdded extends AggregateChanged
{
    public static function withData(
        CommentId $commentId,
        IdeaId $ideaId,
        UserId $userId,
        CommentText $commentText
    ): self {
        return self::occur($commentId->value(), [
            'ideaId' => $ideaId->toString(),
            'userId' => $userId->toString(),
            'text' => $commentText->value(),
        ]);
    }

    public function commentId(): CommentId
    {
        return new CommentId($this->aggregateId());
    }

    public function ideaId(): IdeaId
    {
        return IdeaId::fromString($this->payload()['ideaId']);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->payload()['userId']);
    }

    public function text(): CommentText
    {
        return new CommentText($this->payload()['text']);
    }
}
