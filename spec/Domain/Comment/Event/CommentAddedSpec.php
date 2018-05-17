<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Comment\Event;

use App\Domain\Comment\Model\CommentId;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

class CommentAddedSpec extends ObjectBehavior
{
    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_comment_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new CommentId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
            new UserId('0c586173-7676-4a2c-9220-edd223eb458e'),
            'Lorem ipsum',
        ]);

        $this->id()->shouldBeLike(new CommentId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
        $this->ideaId()->shouldBeLike(new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'));
        $this->userId()->shouldBeLike(new UserId('0c586173-7676-4a2c-9220-edd223eb458e'));
        $this->text()->shouldBeLike('Lorem ipsum');
    }
}
