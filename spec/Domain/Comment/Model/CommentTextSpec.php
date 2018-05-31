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

namespace spec\App\Domain\Comment\Model;

use App\Domain\Comment\Exception\EmptyCommentTextException;
use App\Domain\Comment\Model\CommentText;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class CommentTextSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('Text');
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_not_be_blank(): void
    {
        $emptyText = '';

        $this->shouldThrow(EmptyCommentTextException::class)->during(
            '__construct',
            [
                $emptyText,
            ]
        );
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('Text');
    }

    public function it_has_a_text(): void
    {
        $this->text()->shouldBe('Text');
    }

    public function it_can_be_compared_with_other_comment_text(): void
    {
        $sameCommentId = new CommentText('Text');
        $notSameCommentId = new CommentText('Other text');

        $this->equals($sameCommentId)->shouldBe(true);
        $this->equals($notSameCommentId)->shouldBe(false);
    }
}
