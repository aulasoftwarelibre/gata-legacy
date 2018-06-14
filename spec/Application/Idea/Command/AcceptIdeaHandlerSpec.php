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

use App\Application\Idea\Command\AcceptIdea;
use App\Application\Idea\Exception\IdeaNotFoundException;
use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;
use PhpSpec\ObjectBehavior;

final class AcceptIdeaHandlerSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const GROUP_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';

    public function let(Ideas $ideas): void
    {
        $this->beConstructedWith($ideas);
    }

    public function it_accepts_an_idea(Ideas $ideas, Idea $idea): void
    {
        $ideas->get(new IdeaId(self::IDEA_ID))->shouldBeCalled()->willReturn($idea);
        $idea->accept()->shouldBeCalled();
        $ideas->save($idea)->shouldBeCalled();

        $this(AcceptIdea::create(
            new IdeaId(self::IDEA_ID)
        ));
    }

    public function it_checks_if_idea_does_not_exists(Ideas $ideas)
    {
        $ideas->get(new IdeaId(self::IDEA_ID))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(IdeaNotFoundException::class)->during('__invoke', [
            AcceptIdea::create(
                new IdeaId(self::IDEA_ID)
            ),
        ]);
    }
}
