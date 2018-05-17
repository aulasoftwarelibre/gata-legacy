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

namespace spec\App\Domain\Idea\Event;

use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class IdeaAddedSpec extends ObjectBehavior
{
    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_idea_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
            new IdeaStatus('pending'),
            'Title',
            'Description',
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'));
        $this->ideaStatus()->shouldBeLike(new IdeaStatus('pending'));
        $this->title()->shouldBeLike('Title');
        $this->description()->shouldBeLike('Description');
    }
}
