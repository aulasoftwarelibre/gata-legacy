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

namespace spec\App\Domain\Idea\Model;

use App\Domain\AggregateRoot;
use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Event\IdeaAccepted;
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use App\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

final class IdeaSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const GROUP_ID = '805d3cef-5408-48bc-98c4-dcd04d496eb5';
    const TITLE = 'Lorem Ipsum';
    const DESCRIPTION = 'Aliquam auctor';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new IdeaId(self::IDEA_ID),
            new GroupId(self::GROUP_ID),
            new IdeaTitle(self::TITLE),
            new IdeaDescription(self::DESCRIPTION),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAdded::withData(
                new IdeaId(self::IDEA_ID),
                new GroupId(self::GROUP_ID),
                new IdeaTitle(self::TITLE),
                new IdeaDescription(self::DESCRIPTION)
            )
        );
    }

    public function it_is_an_aggregate(): void
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::TITLE);
    }

    public function it_has_an_idea_id(): void
    {
        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
    }

    public function it_is_pending_by_default(): void
    {
        $this->ideaStatus()->shouldBeLike(IdeaStatus::PENDING());
    }

    public function it_has_a_group_id(): void
    {
        $this->groupId()->shouldBeLike(new GroupId(self::GROUP_ID));
    }

    public function it_has_an_idea_title(): void
    {
        $this->ideaTitle()->shouldBeLike(new IdeaTitle(self::TITLE));
    }

    public function it_has_an_idea_description(): void
    {
        $this->ideaDescription()->shouldBeLike(new IdeaDescription(self::DESCRIPTION));
    }

    public function it_can_be_accepted(): void
    {
        $this->accept();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAccepted::withData(
                new IdeaId(self::IDEA_ID)
            )
        );

        $this->ideaStatus()->shouldBeLike(IdeaStatus::ACCEPTED());
    }
}
