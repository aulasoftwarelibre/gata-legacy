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

namespace spec\AulaSoftwareLibre\Gata\Application\Idea\Command;

use AulaSoftwareLibre\Gata\Application\Idea\Command\UnregisterIdeaAttendee;
use AulaSoftwareLibre\Gata\Application\Idea\Exception\IdeaNotFoundException;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;

final class UnregisterIdeaAttendeeHandlerSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const USER_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function let(Ideas $ideas): void
    {
        $this->beConstructedWith($ideas);
    }

    public function it_unregister_an_idea_attendee(Ideas $ideas, Idea $idea): void
    {
        $ideas->get(new IdeaId(self::IDEA_ID))->shouldBeCalled()->willReturn($idea);
        $idea->unregisterAttendee(new UserId(self::USER_ID))->shouldBeCalled();
        $ideas->save($idea)->shouldBeCalled();

        $this(UnregisterIdeaAttendee::create(
            new IdeaId(self::IDEA_ID),
            new UserId(self::USER_ID)
        ));
    }

    public function it_checks_if_idea_does_not_exists(Ideas $ideas): void
    {
        $ideas->get(new IdeaId(self::IDEA_ID))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(IdeaNotFoundException::class)->during('__invoke', [
            UnregisterIdeaAttendee::create(
                new IdeaId(self::IDEA_ID),
                new UserId(self::USER_ID)
            ),
        ]);
    }
}
