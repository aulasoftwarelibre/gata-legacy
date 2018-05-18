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

namespace spec\App\Domain\Group\Event;

use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\Name;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

class GroupAddedSpec extends ObjectBehavior
{
    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_group_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('Lorem ipsum'),
            'Lorem ipsum',
        ]);

        $this->id()->shouldBeLike(new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
        $this->name()->shouldBeLike(new Name('Lorem ipsum'));
    }
}
