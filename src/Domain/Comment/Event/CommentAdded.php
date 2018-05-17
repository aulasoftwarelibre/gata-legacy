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

namespace App\Domain\Comment\Event;

use App\Domain\Comment\Model\CommentId;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use Prooph\EventSourcing\AggregateChanged;

class CommentAdded extends AggregateChanged
{
    public static function withData(CommentId $commentId, IdeaId $ideaId, UserId $userId, string $text): self
    {
        return self::occur($commentId->id(), [
            'ideaId' => $ideaId->id(),
            'userId' => $userId->id(),
            'text' => $text,
        ]);
    }

    public function id(): CommentId
    {
        return new CommentId($this->aggregateId());
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->payload()['ideaId']);
    }

    public function userId(): UserId
    {
        return new UserId($this->payload()['userId']);
    }

    public function text(): string
    {
        return $this->payload()['text'];
    }
}
