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

namespace spec\App\Domain\Idea\Event;

use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class IdeaVotedSpec extends ObjectBehavior
{
    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_idea_voted_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
            new UserId('0c586173-7676-4a2c-9220-edd223eb458e'),
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'));
        $this->userId()->shouldBeLike(new UserId('0c586173-7676-4a2c-9220-edd223eb458e'));
    }
}
