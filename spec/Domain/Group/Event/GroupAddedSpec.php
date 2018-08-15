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

namespace spec\AulaSoftwareLibre\Gata\Domain\Group\Event;

use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class GroupAddedSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_group_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new GroupId(self::UUID),
            new GroupName('Name'),
        ]);

        $this->groupId()->shouldBeLike(new GroupId(self::UUID));
        $this->name()->shouldBeLike(new GroupName('Name'));
    }
}
