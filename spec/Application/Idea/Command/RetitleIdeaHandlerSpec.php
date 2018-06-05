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

namespace spec\App\Application\Idea\Command;

use App\Application\Idea\Command\RetitleIdea;
use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaTitle;
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
        $ideas->get(Argument::exact(new IdeaId(self::IDEA_ID)))->willReturn($idea);

        $idea->retitle(Argument::exact(new IdeaTitle('Title')))->shouldBeCalled();

        $ideas->save($idea)->shouldBeCalled();

        $this(RetitleIdea::create(
            new IdeaId(self::IDEA_ID),
            new IdeaTitle('Title')
        ));
    }
}
