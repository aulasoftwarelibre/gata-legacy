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

namespace spec\AulaSoftwareLibre\Gata\Application\Group\Command;

use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class RenameGroupSpec extends ObjectBehavior
{
    const GROUP_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';

    public function it_is_a_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    public function it_represents_rename_group_intention(): void
    {
        $this->beConstructedThrough('create', [
            new GroupId(self::GROUP_ID),
            new GroupName('Name'),
        ]);

        $this->groupId()->shouldBeLike(new GroupId(self::GROUP_ID));
        $this->name()->shouldBeLike(new GroupName('Name'));
    }
}
