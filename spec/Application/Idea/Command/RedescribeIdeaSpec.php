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

use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class RedescribeIdeaSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function it_is_a_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    public function it_represents_redescribe_idea_intention(): void
    {
        $this->beConstructedThrough('create', [
            new IdeaId(self::IDEA_ID),
            new IdeaDescription('Description'),
        ]);

        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
        $this->description()->shouldBeLike(new IdeaDescription('Description'));
    }
}
