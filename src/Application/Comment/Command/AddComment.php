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

namespace App\Application\Comment\Command;

use App\Domain\Comment\Model\CommentId;
use App\Domain\Comment\Model\CommentText;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
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
            'userId' => $userId->value(),
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
        return new UserId($this->payload()['userId']);
    }

    public function text()
    {
        return new CommentText($this->payload()['text']);
    }
}
