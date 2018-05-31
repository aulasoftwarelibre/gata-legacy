<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\Group\Command;

use App\Application\Group\Exception\GroupNotFoundException;
use App\Application\Group\Repository\Groups;
use App\Domain\Group\Model\Group;

final class RenameGroupHandler
{
    /**
     * @var Groups
     */
    private $groups;

    public function __construct(Groups $groups)
    {
        $this->groups = $groups;
    }

    public function __invoke(RenameGroup $renameGroup): void
    {
        $group = $this->groups->get($renameGroup->groupId());

        if (!$group instanceof Group) {
            throw new GroupNotFoundException();
        }

        $group->rename($renameGroup->name());

        $this->groups->save($group);
    }
}
