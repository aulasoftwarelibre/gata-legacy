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

use App\Domain\Idea\Model\IdeaCapacity;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaCapacitySpec extends ObjectBehavior
{
    const COUNT = 1;
    const LIMIT = 2;
    const OTHER_COUNT = 3;
    const OTHER_LIMIT = 4;

    public function let(): void
    {
        $this->beConstructedWith(self::COUNT, self::LIMIT);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_be_a_string(): void
    {
        $count = self::COUNT;
        $limit = self::LIMIT;

        $this->__toString()->shouldBe("$count/$limit");
    }

    public function it_has_a_count(): void
    {
        $this->count()->shouldBe(self::COUNT);
    }

    public function it_has_a_limit(): void
    {
        $this->limit()->shouldBe(self::LIMIT);
    }

    public function it_can_be_compared_with_other_idea_capacity()
    {
        $sameIdeaCapacity = new IdeaCapacity(self::COUNT, self::LIMIT);
        $this->equals($sameIdeaCapacity)->shouldBe(true);

        $notSameIdeaCapacity = new IdeaCapacity(self::COUNT, self::OTHER_LIMIT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);

        $notSameIdeaCapacity = new IdeaCapacity(self::OTHER_COUNT, self::LIMIT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);

        $notSameIdeaCapacity = new IdeaCapacity(self::OTHER_COUNT, self::OTHER_LIMIT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);
    }
}
