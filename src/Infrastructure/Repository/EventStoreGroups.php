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

namespace App\Infrastructure\Repository;

use App\Application\Group\Repository\Groups;
use App\Domain\Group\Model\Group;
use App\Domain\Group\Model\GroupId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

class EventStoreGroups extends AggregateRepository implements Groups
{
    public function save(Group $group): void
    {
        $this->saveAggregateRoot($group);
    }

    public function get(GroupId $groupId): ?Group
    {
        return $this->getAggregateRoot($groupId->value());
    }
}
