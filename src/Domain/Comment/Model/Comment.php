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

use App\Domain\AggregateRoot;
use App\Domain\Comment\Event\CommentAdded;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;

final class Comment extends AggregateRoot
{
    /**
     * @var CommentId
     */
    private $commentId;

    /**
     * @var IdeaId
     */
    private $ideaId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var CommentText
     */
    private $commentText;

    public static function add(CommentId $commentId, IdeaId $ideaId, UserId $userId, CommentText $commentText)
    {
        $comment = new self();

        $comment->recordThat(CommentAdded::withData($commentId, $ideaId, $userId, $commentText));

        return $comment;
    }

    public function __toString(): string
    {
        return $this->commentText()->text();
    }

    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    public function ideaId(): IdeaId
    {
        return $this->ideaId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function commentText(): CommentText
    {
        return $this->commentText;
    }

    protected function aggregateId(): string
    {
        return $this->commentId->id();
    }

    protected function applyCommentAdded(CommentAdded $event): void
    {
        $this->commentId = $event->commentId();
        $this->ideaId = $event->ideaId();
        $this->userId = $event->userId();
        $this->commentText = $event->commentText();
    }
}
