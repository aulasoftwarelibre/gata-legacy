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

use App\Domain\Idea\Exception\ExceededCapacityLimitException;
use App\Domain\Idea\Exception\InvalidIdeaCapacityException;
use App\Domain\Idea\Model\IdeaCapacity;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaCapacitySpec extends ObjectBehavior
{
    const COUNT = 1;
    const OTHER_COUNT = 2;
    const LIMIT = 3;
    const OTHER_LIMIT = 4;

    public function let(): void
    {
        $this->beConstructedWith(self::LIMIT, self::COUNT);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_is_unlimited_and_starts_counting_from_zero_by_default(): void
    {
        $this->beConstructedWith();

        $this->limit()->shouldBe(null);
        $this->count()->shouldBe(0);
    }

    public function it_can_not_have_negative_or_zero_limit_values(): void
    {
        $this->shouldThrow(InvalidIdeaCapacityException::class)->during(
            '__construct', [
                -1,
            ]
        );

        $this->shouldThrow(InvalidIdeaCapacityException::class)->during(
            '__construct', [
                0,
            ]
        );
    }

    public function it_can_not_start_counting_from_negative_values(): void
    {
        $this->shouldThrow(InvalidIdeaCapacityException::class)->during(
            '__construct', [
                1,
                -1,
            ]
        );
    }

    public function it_can_not_exceed_the_limit(): void
    {
        $this->shouldThrow(ExceededCapacityLimitException::class)->during(
            '__construct', [
                1,
                2,
            ]
        );
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

    public function it_can_increment(): void
    {
        $this->increment()->limit()->shouldBe(self::LIMIT);
        $this->increment()->count()->shouldBe(self::COUNT + 1);
        $this->count()->shouldBe(self::COUNT);
        $this->limit()->shouldBe(self::LIMIT);
    }

    public function it_can_decrement(): void
    {
        $this->decrement()->limit()->shouldBe(self::LIMIT);
        $this->decrement()->count()->shouldBe(self::COUNT - 1);
        $this->count()->shouldBe(self::COUNT);
        $this->limit()->shouldBe(self::LIMIT);
    }

    public function it_can_be_unlimited(): void
    {
        $this->unlimited()->limit()->shouldBe(null);
        $this->unlimited()->count()->shouldBe(self::COUNT);
        $this->count()->shouldBe(self::COUNT);
        $this->limit()->shouldBe(self::LIMIT);
    }

    public function it_can_be_limited(): void
    {
        $this->limited(self::OTHER_LIMIT)->limit()->shouldBe(self::OTHER_LIMIT);
        $this->limited(self::OTHER_LIMIT)->count()->shouldBe(self::COUNT);
        $this->count()->shouldBe(self::COUNT);
        $this->limit()->shouldBe(self::LIMIT);
    }

    public function it_can_be_compared_with_other_idea_capacity(): void
    {
        $sameIdeaCapacity = new IdeaCapacity(self::LIMIT, self::COUNT);
        $this->equals($sameIdeaCapacity)->shouldBe(true);

        $notSameIdeaCapacity = new IdeaCapacity(self::LIMIT, self::OTHER_COUNT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);

        $notSameIdeaCapacity = new IdeaCapacity(self::OTHER_LIMIT, self::COUNT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);

        $notSameIdeaCapacity = new IdeaCapacity(self::OTHER_LIMIT, self::OTHER_COUNT);
        $this->equals($notSameIdeaCapacity)->shouldBe(false);
    }
}
