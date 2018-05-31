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

use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use App\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class IdeaAddedSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const GROUP_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }

    public function it_represents_idea_added_event_occurrence(): void
    {
        $this->beConstructedThrough('withData', [
            new IdeaId(self::IDEA_ID),
            new GroupId(self::GROUP_ID),
            new IdeaTitle('Title'),
            new IdeaDescription('Description'),
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
        $this->groupId()->shouldBeLike(new GroupId(self::GROUP_ID));
        $this->status()->shouldBeLike(IdeaStatus::PENDING());
        $this->title()->shouldBeLike(new IdeaTitle('Title'));
        $this->description()->shouldBeLike(new IdeaDescription('Description'));
    }
}
