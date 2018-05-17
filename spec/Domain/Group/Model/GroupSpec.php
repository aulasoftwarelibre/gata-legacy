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

use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupUpdated;
use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

class GroupSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            'Lorem ipsum',
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupAdded::withData(
                new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                'Lorem ipsum'
            )
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Group::class);
    }

    public function it_has_an_id(): void
    {
        $this->id()->shouldBeLike(new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
    }

    public function it_has_a_name(): void
    {
        $this->name()->shouldBeLike('Lorem ipsum');
    }

    public function it_can_update_its_name(): void
    {
        $this->changeName('Quis aute');

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupUpdated::withData(
                new GroupId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                'Quis aute'
            )
        );
    }
}
