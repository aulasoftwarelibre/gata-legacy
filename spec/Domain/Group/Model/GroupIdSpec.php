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

use App\Domain\Group\Exception\InvalidGroupIdFormatException;
use App\Domain\Group\Model\GroupId;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class GroupIdSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const OTHER_UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a57';
    const INVALID_UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a5';

    public function let(): void
    {
        $this->beConstructedWith(self::UUID);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_has_to_be_valid(): void
    {
        $this->shouldThrow(InvalidGroupIdFormatException::class)->during(
            '__construct',
            [self::INVALID_UUID]
        );
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::UUID);
    }

    public function it_has_an_id(): void
    {
        $this->id()->shouldBe(self::UUID);
    }

    public function it_can_be_compared_with_other_group_id()
    {
        $sameGroupId = new GroupId(self::UUID);
        $notSameGroupId = new GroupId(self::OTHER_UUID);

        $this->equals($sameGroupId)->shouldBe(true);
        $this->equals($notSameGroupId)->shouldBe(false);
    }
}
