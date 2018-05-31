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
use App\Domain\Idea\Model\IdeaStatus;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class IdeaAcceptedSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_idea_accepted_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new IdeaId(self::UUID),
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId(self::UUID));
        $this->status()->shouldBeLike(IdeaStatus::ACCEPTED());
    }
}
