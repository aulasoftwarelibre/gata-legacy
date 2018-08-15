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

namespace spec\AulaSoftwareLibre\Gata\Application\Idea\Command;

use AulaSoftwareLibre\Gata\Application\Idea\Command\AddIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class AddIdeaHandlerSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const GROUP_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function let(Ideas $ideas): void
    {
        $this->beConstructedWith($ideas);
    }

    public function it_creates_an_idea(Ideas $ideas): void
    {
        $ideas->save(Argument::that(
            function (Idea $idea) {
                return $idea->ideaId()->equals(new IdeaId(self::IDEA_ID))
                    && $idea->groupId()->equals(GroupId::fromString(self::GROUP_ID))
                    && $idea->title()->equals(new IdeaTitle('Title'))
                    && $idea->description()->equals(new IdeaDescription('Description'))
                ;
            }
        ))->shouldBeCalled();

        $this(AddIdea::create(
            new IdeaId(self::IDEA_ID),
            GroupId::fromString(self::GROUP_ID),
            new IdeaTitle('Title'),
            new IdeaDescription('Description')
        ));
    }
}
