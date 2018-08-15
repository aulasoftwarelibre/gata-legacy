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

namespace spec\AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\View;

use PhpSpec\ObjectBehavior;

final class GroupViewSpec extends ObjectBehavior
{
    const UUID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function let(): void
    {
        $this->beConstructedWith(self::UUID, 'Name');
    }

    public function it_is_simplified_group_view(): void
    {
        $this->id()->shouldReturn(self::UUID);
        $this->name()->shouldReturn('Name');
    }

    public function it_can_be_renamed(): void
    {
        $this->rename('Other name');

        $this->name()->shouldReturn('Other name');
    }
}
