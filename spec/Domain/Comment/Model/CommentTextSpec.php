<?php

declare(strict_types=1);

namespace spec\App\Domain\Comment\Model;

use App\Domain\Comment\Exception\EmptyCommentTextException;
use App\Domain\Comment\Model\CommentText;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class CommentTextSpec extends ObjectBehavior
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
        $this->shouldHaveType(ValueObject::class);
    }

    public function it_can_not_be_blank(): void
    {
        $this->shouldThrow(EmptyCommentTextException::class)->during(
            '__construct',
            [self::EMPTY_TEXT]
        );
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::TEXT);
    }

    public function it_has_a_text(): void
    {
        $this->text()->shouldBe(self::TEXT);
    }

    public function it_can_be_compared_with_other_comment_text()
    {
        $sameCommentId = new CommentText(self::TEXT);
        $notSameCommentId = new CommentText(self::OTHER_TEXT);

        $this->equals($sameCommentId)->shouldBe(true);
        $this->equals($notSameCommentId)->shouldBe(false);
    }
}