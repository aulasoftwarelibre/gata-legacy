<?php

declare(strict_types=1);

namespace spec\App\Domain\User\Model;

use App\Domain\User\Exception\InvalidUuidFormatException;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class UserIdSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const NOT_VALID_UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a5';
    const OTHER_UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a57';

    function let()
    {
        $uuid = self::UUID;

        $this->beConstructedWith($uuid);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserId::class);
    }

    function it_can_be_created_from_string(): void
    {
        $this->id()->shouldBe(self::UUID);
    }

    function it_has_to_be_valid(): void
    {
        $this->shouldThrow(InvalidUuidFormatException::class)->during('__construct', [self::NOT_VALID_UUID]);
    }

    function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::UUID);
    }

    function it_can_be_compared_with_other_user_id(
        UserId $sameUserId,
        UserId $notSameUserId
    ) {
        $sameUserId->id()->shouldBeCalled()->willReturn(self::UUID);
        $notSameUserId->id()->shouldBeCalled()->willReturn(self::OTHER_UUID);

        $this->equals($sameUserId)->shouldBe(true);
        $this->equals($notSameUserId)->shouldBe(false);
    }
}
