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

namespace AulaSoftwareLibre\Gata\Application\Comment\Command;

use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class AddComment extends Command
{
    use PayloadTrait;

    public static function create(
        CommentId $commentId,
        IdeaId $ideaId,
        UserId $userId,
        CommentText $commentText
    ) {
        return new self([
            'commentId' => $commentId->value(),
            'ideaId' => $ideaId->value(),
            'userId' => $userId->toString(),
            'text' => $commentText->value(),
        ]);
    }

    public function commentId()
    {
        return new CommentId($this->payload()['commentId']);
    }

    public function ideaId()
    {
        return new IdeaId($this->payload()['ideaId']);
    }

    public function userId()
    {
        return UserId::fromString($this->payload()['userId']);
    }

    public function text()
    {
        return new CommentText($this->payload()['text']);
    }
}
