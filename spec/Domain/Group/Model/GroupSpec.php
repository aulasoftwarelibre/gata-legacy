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

namespace spec\App\Domain\Group\Model;

use App\Domain\AggregateRoot;
use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupUpdated;
use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

final class GroupSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const NAME = 'Lorem ipsum';
    const OTHER_NAME = 'Aliquam auctor';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new GroupId(self::UUID),
            new GroupName(self::NAME),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupAdded::withData(
                new GroupId(self::UUID),
                new GroupName(self::NAME)
            )
        );
    }

    public function it_is_an_aggregate(): void
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::NAME);
    }

    public function it_has_a_group_id(): void
    {
        $this->groupId()->shouldBeLike(new GroupId(self::UUID));
    }

    public function it_has_a_group_name(): void
    {
        $this->groupName()->shouldBeLike(new GroupName(self::NAME));
    }

    public function it_can_update_its_group_name(): void
    {
        $this->changeGroupName(new GroupName(self::OTHER_NAME));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupUpdated::withData(
                new GroupId(self::UUID),
                new GroupName(self::OTHER_NAME)
            )
        );

        $this->groupName()->shouldBeLike(new GroupName(self::OTHER_NAME));
    }
}
