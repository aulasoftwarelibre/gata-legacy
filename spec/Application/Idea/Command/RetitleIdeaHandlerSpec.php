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

use AulaSoftwareLibre\Gata\Application\Idea\Command\RetitleIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class RetitleIdeaHandlerSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function let(Ideas $ideas): void
    {
        $this->beConstructedWith($ideas);
    }

    public function it_retitle_an_idea(Ideas $ideas, Idea $idea): void
    {
        $ideas->get(Argument::exact(IdeaId::fromString(self::IDEA_ID)))->willReturn($idea);

        $idea->retitle(Argument::exact(IdeaTitle::fromString('Title')))->shouldBeCalled();

        $ideas->save($idea)->shouldBeCalled();

        $this(RetitleIdea::with(
            IdeaId::fromString(self::IDEA_ID),
            IdeaTitle::fromString('Title')
        ));
    }
}
