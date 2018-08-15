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

namespace spec\AulaSoftwareLibre\Gata\Domain\Comment\Event;

use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class CommentAddedSpec extends ObjectBehavior
{
    const COMMENT_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const IDEA_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';
    const USER_ID = '0c586173-7676-4a2c-9220-edd223eb458e';

    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_comment_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new CommentId(self::COMMENT_ID),
            new IdeaId(self::IDEA_ID),
            new UserId(self::USER_ID),
            new CommentText('Text'),
        ]);

        $this->commentId()->shouldBeLike(new CommentId(self::COMMENT_ID));
        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
        $this->userId()->shouldBeLike(new UserId(self::USER_ID));
        $this->text()->shouldBeLike(new CommentText('Text'));
    }
}
