<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Idea\Command;

use App\Application\Idea\Command\RedescribeIdea;
use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class RedescribeIdeaHandlerSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function let(Ideas $ideas): void
    {
        $this->beConstructedWith($ideas);
    }

    public function it_redescribe_an_idea(Ideas $ideas, Idea $idea): void
    {
        $ideas->get(Argument::exact(new IdeaId(self::IDEA_ID)))->willReturn($idea);

        $idea->redescribe(Argument::exact(new IdeaDescription('Description')))->shouldBeCalled();

        $ideas->save($idea)->shouldBeCalled();

        $this(RedescribeIdea::create(
            new IdeaId(self::IDEA_ID),
            new IdeaDescription('Description')
        ));
    }
}
