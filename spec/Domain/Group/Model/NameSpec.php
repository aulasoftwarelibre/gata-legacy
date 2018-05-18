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

use App\Domain\Group\Exception\EmptyNameException;
use App\Domain\Group\Model\Name;
use App\Domain\ValueObject;
use PhpSpec\ObjectBehavior;

class NameSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('Lorem ipsum');
    }

    public function it_is_a_value_object()
    {
        $this->shouldHaveType(ValueObject::class);
    }

    public function it_is_a_name(): void
    {
        $this->value()->shouldBeLike('Lorem ipsum');
    }

    public function it_cannot_be_null()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(EmptyNameException::class)->duringInstantiation();
    }

    public function it_can_be_compared_with_other_value_object(Name $name, ValueObject $object)
    {
        $name->value()->willReturn('Quis aute');
        $this->equals($this->getWrappedObject())->shouldBe(true);
        $this->equals($name)->shouldBe(false);
        $this->equals($object)->shouldBe(false);
    }
}
