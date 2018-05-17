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

use App\Domain\Idea\Exception\InvalidIdeaStatusException;
use App\Domain\Idea\Model\IdeaStatus;
use PhpSpec\ObjectBehavior;

class IdeaStatusSpec extends ObjectBehavior
{
    const STATUS = 'accepted';
    const NOT_VALID_STATUS = 'modified';

    public function let(): void
    {
        $this->beConstructedWith(self::STATUS);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(IdeaStatus::class);
    }

    public function it_can_be_created_from_string(): void
    {
        $this->status()->shouldBe(self::STATUS);
    }

    public function it_has_to_be_valid(): void
    {
        $this->shouldThrow(InvalidIdeaStatusException::class)->during(
            '__construct',
            [self::NOT_VALID_STATUS]
        );
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::STATUS);
    }

    public function it_can_be_compared_with_other_idea_status(
        IdeaStatus $sameIdeaStatus,
        IdeaStatus $notSameIdeaStatus
    ) {
        $sameIdeaStatus->status()->shouldBeCalled()->willReturn(self::STATUS);
        $notSameIdeaStatus->status()->shouldBeCalled()->willReturn(self::NOT_VALID_STATUS);

        $this->equals($sameIdeaStatus)->shouldBe(true);
        $this->equals($notSameIdeaStatus)->shouldBe(false);
    }
}
