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

use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

class IdeaSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
            new IdeaStatus('pending'),
            'Title',
            'Description',
        ]);
        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAdded::withData(
                new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
                new IdeaStatus('pending'),
                'Title',
                'Description'
            )
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Idea::class);
    }

    public function it_has_an_idea_id(): void
    {
        $this->ideaId()->shouldBeLike(new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'));
    }

    public function it_has_an_idea_status(): void
    {
        $this->ideaStatus()->shouldBeLike(new IdeaStatus('pending'));
    }

    public function it_has_a_title(): void
    {
        $this->title()->shouldBeLike('Title');
    }

    public function it_has_a_description(): void
    {
        $this->description()->shouldBeLike('Description');
    }
}
