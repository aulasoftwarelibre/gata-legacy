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
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use App\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

final class IdeaSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const TITLE = 'Lorem Ipsum';
    const DESCRIPTION = 'Aliquam auctor';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new IdeaId(self::UUID),
            new IdeaTitle(self::TITLE),
            new IdeaDescription(self::DESCRIPTION),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAdded::withData(
                new IdeaId(self::UUID),
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
        $this->ideaId()->shouldBeLike(new IdeaId(self::UUID));
    }

    public function it_is_pending_by_default(): void
    {
        $this->ideaStatus()->shouldBeLike(IdeaStatus::PENDING());
    }

    public function it_has_an_idea_title(): void
    {
        $this->ideaTitle()->shouldBeLike(new IdeaTitle(self::TITLE));
    }

    public function it_has_an_idea_description(): void
    {
        $this->ideaDescription()->shouldBeLike(new IdeaDescription(self::DESCRIPTION));
    }
}
