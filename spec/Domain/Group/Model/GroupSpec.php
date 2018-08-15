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
use App\Domain\Group\Event\GroupRenamed;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaTitle;
use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Spec\AggregateAsserter;
use PhpSpec\ObjectBehavior;
use Prooph\EventSourcing\AggregateRoot;

final class GroupSpec extends ObjectBehavior
{
    const GROUP_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const IDEA_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new GroupId(self::GROUP_ID),
            new GroupName('Name'),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupAdded::withData(
                new GroupId(self::GROUP_ID),
                new GroupName('Name')
            )
        );
    }

    public function it_is_an_aggregate(): void
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('Name');
    }

    public function it_has_a_group_id(): void
    {
        $this->groupId()->shouldBeLike(new GroupId(self::GROUP_ID));
    }

    public function it_has_a_name(): void
    {
        $this->name()->shouldBeLike(new GroupName('Name'));
    }

    public function it_can_add_ideas(): void
    {
        $idea = $this->addIdea(
            new IdeaId(self::IDEA_ID),
            new IdeaTitle('Title'),
            new IdeaDescription('Description')
        );

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $idea->getWrappedObject(),
            IdeaAdded::withData(
                new IdeaId(self::IDEA_ID),
                new GroupId(self::GROUP_ID),
                new IdeaTitle('Title'),
                new IdeaDescription('Description')
            )
        );
    }

    public function it_can_change_its_name(): void
    {
        $this->rename(new GroupName('Other name'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupRenamed::withData(
                new GroupId(self::GROUP_ID),
                new GroupName('Other name')
            )
        );

        $this->name()->shouldBeLike(new GroupName('Other name'));
    }
}
