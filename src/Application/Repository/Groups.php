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

namespace App\Application\Repository;

use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;

interface Groups
{
    public function save(Group $group): void;

    public function get(GroupId $groupId): ?Group;
}
