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

namespace spec\App\Application\Comment\Command;

use App\Application\Comment\Command\AddComment;
use App\Domain\Comment\Model\CommentId;
use App\Domain\Comment\Model\CommentText;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;

class AddCommentSpec extends ObjectBehavior
{
    const COMMENT_ID = '16aa92e9-f794-44b7-9854-f16eb4ac9ca2';
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const USER_ID = '25726241-b562-4a55-bc09-406f13cae682';

    public function it_is_a_command(): void
    {
        $this->shouldHaveType(AddComment::class);
    }

    public function it_represents_add_comment_intention(): void
    {
        $this->beConstructedThrough('create', [
            new CommentId(self::COMMENT_ID),
            new IdeaId(self::IDEA_ID),
            new UserId(self::USER_ID),
            new CommentText('Lorem Ipsum'),
        ]);

        $this->commentId()->shouldBeLike(new CommentId(self::COMMENT_ID));
        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
        $this->userId()->shouldBeLike(new UserId(self::USER_ID));
        $this->text()->shouldBeLike(new CommentText('Lorem Ipsum'));
    }
}
