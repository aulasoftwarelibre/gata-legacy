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

namespace AulaSoftwareLibre\Gata\Application\Group\Command;

use AulaSoftwareLibre\Gata\Application\Group\Repository\Groups;
use AulaSoftwareLibre\Gata\Domain\Group\Model\Group;

final class AddGroupHandler
{
    /**
     * @var Groups
     */
    private $groups;

    public function __construct(Groups $groups)
    {
        $this->groups = $groups;
    }

    public function __invoke(AddGroup $addGroup): void
    {
        $group = Group::add(
            $addGroup->groupId(),
            $addGroup->name()
        );

        $this->groups->save($group);
    }
}
