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
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class GroupAddedProjectionSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function let(GroupViews $groupViews): void
    {
        $this->beConstructedWith($groupViews);
    }

    public function it_creates_a_group_view(GroupViews $groupViews): void
    {
        $groupViews->add(Argument::exact(new GroupView(
            self::UUID,
            'Name'
        )))->shouldBeCalled();

        $groupViews->save()->shouldBeCalled();

        $this(GroupAdded::withData(
            new GroupId(self::UUID),
            new GroupName('Name')
        ));
    }
}
