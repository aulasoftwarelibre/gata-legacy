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

use App\Application\Comment\Repository\Comments;
use App\Application\Idea\Exception\IdeaNotFoundException;
use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;

class AddCommentHandler
{
    /**
     * @var Ideas
     */
    private $ideas;
    /**
     * @var Comments
     */
    private $comments;

    public function __construct(Ideas $ideas, Comments $comments)
    {
        $this->ideas = $ideas;
        $this->comments = $comments;
    }

    public function __invoke(AddComment $addComment): void
    {
        $idea = $this->ideas->get($addComment->ideaId());

        if (!$idea instanceof Idea) {
            throw new IdeaNotFoundException();
        }

        $comment = $idea->addComment(
            $addComment->commentId(),
            $addComment->userId(),
            $addComment->text()
        );

        $this->comments->save($comment);
    }
}
