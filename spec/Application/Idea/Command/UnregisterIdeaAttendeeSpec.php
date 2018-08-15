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

use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class UnregisterIdeaAttendeeSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const USER_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function it_is_a_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    public function it_represents_unregister_idea_attendee_intention(): void
    {
        $this->beConstructedThrough('create', [
            new IdeaId(self::IDEA_ID),
            UserId::fromString(self::USER_ID),
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
        $this->userId()->shouldBeLike(UserId::fromString(self::USER_ID));
    }
}
