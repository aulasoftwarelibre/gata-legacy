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

use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaDescriptionSpec extends ObjectBehavior
{
    const DESCRIPTION = 'Lorem ipsum';
    const OTHER_DESCRIPTION = 'Aliquam auctor';

    public function let(): void
    {
        $this->beConstructedWith(self::DESCRIPTION);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe(self::DESCRIPTION);
    }

    public function it_has_a_description(): void
    {
        $this->description()->shouldBe(self::DESCRIPTION);
    }

    public function it_can_be_compared_with_other_idea_title()
    {
        $sameIdeaDescription = new IdeaDescription(self::DESCRIPTION);
        $notSameIdeaDescription = new IdeaDescription(self::OTHER_DESCRIPTION);

        $this->equals($sameIdeaDescription)->shouldBe(true);
        $this->equals($notSameIdeaDescription)->shouldBe(false);
    }
}
