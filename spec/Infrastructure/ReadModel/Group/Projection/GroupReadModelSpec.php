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

namespace spec\AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Projection;

use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupWasAdded;
use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupWasRenamed;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Repository\GroupViews;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\View\GroupView;
use PhpSpec\ObjectBehavior;
use Prooph\EventStore\Projection\ReadModel;

class GroupReadModelSpec extends ObjectBehavior
{
    const GROUP_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function let(GroupViews $groupViews)
    {
        $this->beConstructedWith($groupViews);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ReadModel::class);
    }

    public function it_creates_a_group_view(GroupViews $groupViews)
    {
        $groupViews->add(new GroupView(
            self::GROUP_ID,
            'Name'
        ))->shouldBeCalled();

        $this->applyGroupAdded(GroupWasAdded::with(
                GroupId::fromString(self::GROUP_ID),
                GroupName::fromString('Name')
        ));
    }

    public function it_renames_a_group_view(GroupViews $groupViews)
    {
        $groupViews
            ->rename(self::GROUP_ID, 'New name')
            ->shouldBeCalled();

        $this->applyGroupRenamed(GroupWasRenamed::with(
            GroupId::fromString(self::GROUP_ID),
            GroupName::fromString('New name')
        ));
    }
}
