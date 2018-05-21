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

use App\Domain\Idea\Model\IdeaTitle;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaTitleSpec extends ObjectBehavior
{
    const TITLE = 'Lorem ipsum';
    const OTHER_TITLE = 'Aliquam auctor';

    public function let(): void
    {
        $this->beConstructedWith(self::TITLE);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::TITLE);
    }

    public function it_has_a_title(): void
    {
        $this->title()->shouldBe(self::TITLE);
    }

    public function it_can_be_compared_with_other_idea_title()
    {
        $sameIdeaTitle = new IdeaTitle(self::TITLE);
        $notSameIdeaTitle = new IdeaTitle(self::OTHER_TITLE);

        $this->equals($sameIdeaTitle)->shouldBe(true);
        $this->equals($notSameIdeaTitle)->shouldBe(false);
    }
}
