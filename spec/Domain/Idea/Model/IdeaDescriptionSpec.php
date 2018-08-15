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

namespace spec\AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaDescriptionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('Description');
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('Description');
    }

    public function it_has_a_description(): void
    {
        $this->value()->shouldBe('Description');
    }

    public function it_can_be_compared_with_other_idea_description(): void
    {
        $sameIdeaDescription = new IdeaDescription('Description');
        $notSameIdeaDescription = new IdeaDescription('Other description');

        $this->equals($sameIdeaDescription)->shouldBe(true);
        $this->equals($notSameIdeaDescription)->shouldBe(false);
    }
}
