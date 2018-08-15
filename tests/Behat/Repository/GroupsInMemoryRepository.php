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

namespace Tests\Behat\Repository;

use AulaSoftwareLibre\Gata\Application\Group\Exception\GroupNotFoundException;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Repository\GroupViews;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\View\GroupView;

class GroupsInMemoryRepository implements GroupViews
{
    /** @var GroupView[] */
    private $groups;

    public function __construct()
    {
        $this->groups = [];
    }

    public function add(GroupView $groupView): void
    {
        $this->groups[] = $groupView;
    }

    public function get(GroupId $groupId): GroupView
    {
        /** @var GroupView $group */
        foreach ($this->groups as $group) {
            if ($groupId->equals(new GroupId($group->id()))) {
                return $group;
            }
        }

        throw new GroupNotFoundException();
    }

    public function save(): void
    {
    }
}
