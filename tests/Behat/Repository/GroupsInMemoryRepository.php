<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Behat\Repository;

use App\Application\Group\Exception\GroupNotFoundException;
use App\Application\Group\Repository\Groups;
use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;

class GroupsInMemoryRepository implements Groups
{
    /** @var Group[] */
    private $groups;

    public function __construct()
    {
        $this->groups = [];
    }

    public function save(Group $group): void
    {
        $this->groups[] = $group;
    }

    public function get(GroupId $groupId): ?Group
    {
        /** @var Group $group */
        foreach ($this->groups as $group) {
            if ($group->groupId()->equals($groupId)) {
                return $group;
            }
        }

        throw new GroupNotFoundException();
    }
}
