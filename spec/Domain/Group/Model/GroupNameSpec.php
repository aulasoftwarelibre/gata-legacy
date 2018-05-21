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

namespace spec\App\Domain\Group\Model;

use App\Domain\Group\Exception\EmptyGroupNameException;
use App\Domain\Group\Model\GroupName;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class GroupNameSpec extends ObjectBehavior
{
    const TEXT = 'Lorem ipsum';
    const OTHER_TEXT = 'Aliquam auctor';
    const EMPTY_TEXT = '';

    public function let(): void
    {
        $this->beConstructedWith(self::TEXT);
    }

    public function it_is_a_value_object()
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_not_be_blank()
    {
        $this->shouldThrow(EmptyGroupNameException::class)->during(
            '__construct',
            [self::EMPTY_TEXT]
        );
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::TEXT);
    }

    public function it_has_a_name(): void
    {
        $this->name()->shouldBe(self::TEXT);
    }

    public function it_can_be_compared_with_other_group_name()
    {
        $sameGroupName = new GroupName(self::TEXT);
        $notSameGroupName = new GroupName(self::OTHER_TEXT);

        $this->equals($sameGroupName)->shouldBe(true);
        $this->equals($notSameGroupName)->shouldBe(false);
    }
}
