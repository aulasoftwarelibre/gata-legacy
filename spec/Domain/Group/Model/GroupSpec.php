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

namespace spec\AulaSoftwareLibre\Gata\Domain\Group\Model;

use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Spec\AggregateAsserter;
use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupWasAdded;
use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupWasRenamed;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAdded;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Prooph\EventSourcing\AggregateRoot;

final class GroupSpec extends ObjectBehavior
{
    const GROUP_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const IDEA_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            GroupId::fromString(self::GROUP_ID),
            GroupName::fromString('Name'),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupWasAdded::with(
                GroupId::fromString(self::GROUP_ID),
                GroupName::fromString('Name')
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
        $this->groupId()->shouldBeLike(GroupId::fromString(self::GROUP_ID));
    }

    public function it_has_a_name(): void
    {
        $this->name()->shouldBeLike(GroupName::fromString('Name'));
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
                GroupId::fromString(self::GROUP_ID),
                new IdeaTitle('Title'),
                new IdeaDescription('Description')
            )
        );
    }

    public function it_can_change_its_name(): void
    {
        $this->rename(GroupName::fromString('Other name'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            GroupWasRenamed::with(
                GroupId::fromString(self::GROUP_ID),
                GroupName::fromString('Other name')
            )
        );

        $this->name()->shouldBeLike(GroupName::fromString('Other name'));
    }
}
