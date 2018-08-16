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

namespace spec\AulaSoftwareLibre\Gata\Application\Comment\Command;

use AulaSoftwareLibre\Gata\Application\Comment\Command\AddComment;
use AulaSoftwareLibre\Gata\Application\Comment\Repository\Comments;
use AulaSoftwareLibre\Gata\Application\Idea\Exception\IdeaNotFoundException;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\Comment;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;

class AddCommentHandlerSpec extends ObjectBehavior
{
    const COMMENT_ID = '16aa92e9-f794-44b7-9854-f16eb4ac9ca2';
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const USER_ID = '25726241-b562-4a55-bc09-406f13cae682';

    public function let(Ideas $ideas, Comments $comments)
    {
        $this->beConstructedWith($ideas, $comments);
    }

    public function it_adds_a_comment_to_an_idea(
        Ideas $ideas,
        Idea $idea,
        Comments $comments,
        Comment $comment
    ) {
        $ideas->get(IdeaId::fromString(self::IDEA_ID))->shouldBeCalled()->willReturn($idea);
        $idea->addComment(
            CommentId::fromString(self::COMMENT_ID),
            UserId::fromString(self::USER_ID),
            CommentText::fromString('Lorem ipsum')
            )
            ->shouldBeCalled()
            ->willReturn($comment)
        ;
        $comments->save($comment)->shouldBeCalled();

        $this(AddComment::with(
            CommentId::fromString(self::COMMENT_ID),
            IdeaId::fromString(self::IDEA_ID),
            UserId::fromString(self::USER_ID),
            CommentText::fromString('Lorem ipsum')
        ));
    }

    public function it_checks_if_idea_does_not_exists(Ideas $ideas)
    {
        $ideas->get(IdeaId::fromString(self::IDEA_ID))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(IdeaNotFoundException::class)->during('__invoke', [
            AddComment::with(
                CommentId::fromString(self::COMMENT_ID),
                IdeaId::fromString(self::IDEA_ID),
                UserId::fromString(self::USER_ID),
                CommentText::fromString('Lorem ipsum')
            ),
        ]);
    }
}
