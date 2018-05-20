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

use App\Domain\Enum;
use PhpSpec\ObjectBehavior;

class IdeaStatusSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('byName', ['PENDING']);
        $this->getWrappedObject();
    }

    public function it_is_an_enum(): void
    {
        $this->shouldHaveType(Enum::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('PENDING');
    }

    public function it_can_be_compared_with_other_value_object()
    {
        $this->equals($this->getWrappedObject())->shouldBe(true);
    }
}
