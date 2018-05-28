<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Group\Command;

use App\Application\Group\Command\AddGroup;
use App\Application\Group\Command\AddGroupHandler;
use App\Application\Repository\Groups;
use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddGroupHandlerSpec extends ObjectBehavior
{
    const GROUP_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const NAME = 'Lorem ipsum';

    public function let(Groups $groups)
    {
        $this->beConstructedWith($groups);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AddGroupHandler::class);
    }

    public function it_creates_a_group(Groups $groups)
    {
        $groups->save(Argument::that(
            function (Group $group) {
                return $group->id() === new GroupId(self::GROUP_ID);
            }
        ))->shouldBeCalled();

        $this(AddGroup::create(
            new GroupId(self::GROUP_ID),
            new GroupName(self::NAME)
        ));
    }
}
