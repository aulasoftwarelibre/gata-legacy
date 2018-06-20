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

namespace spec\App\Infrastructure\ReadModel\Group\Projection;

use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupRenamed;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;
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

        $this->applyGroupAdded(GroupAdded::withData(
                new GroupId(self::GROUP_ID),
                new GroupName('Name')
        ));
    }

    public function it_renames_a_group_view(GroupViews $groupViews)
    {
        $groupViews
            ->rename(self::GROUP_ID, 'New name')
            ->shouldBeCalled();

        $this->applyGroupRenamed(GroupRenamed::withData(
            new GroupId(self::GROUP_ID),
            new GroupName('New name')
        ));
    }
}
