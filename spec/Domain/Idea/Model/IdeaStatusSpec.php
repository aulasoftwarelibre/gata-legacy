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

use AulaSoftwareLibre\Gata\Domain\Enum;
use AulaSoftwareLibre\Gata\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

final class IdeaStatusSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('byName', [
            'PENDING',
        ]);
    }

    public function it_is_a_value_object(): void
    {
        $this->shouldImplement(ValueObject::class);
    }

    public function it_is_an_enum(): void
    {
        $this->shouldHaveType(Enum::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('PENDING');
    }

    public function it_can_be_compared_with_other_idea_status(): void
    {
        $this->equals($this->getWrappedObject())->shouldBe(true);
    }
}
