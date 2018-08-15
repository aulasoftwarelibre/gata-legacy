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

namespace AulaSoftwareLibre\Gata\Infrastructure\Repository;

use AulaSoftwareLibre\Gata\Application\Group\Exception\GroupNotFoundException;
use AulaSoftwareLibre\Gata\Application\Group\Repository\Groups;
use AulaSoftwareLibre\Gata\Domain\Group\Model\Group;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Ramsey\Uuid\Uuid;

final class EventStoreGroups extends AggregateRepository implements Groups
{
    public function save(Group $group): void
    {
        $this->saveAggregateRoot($group);
    }

    public function get(GroupId $groupId): ?Group
    {
        $group = $this->getAggregateRoot($groupId->toString());

        if (!$group instanceof Group) {
            throw new GroupNotFoundException();
        }

        return $group;
    }

    public function nextIdentity(): GroupId
    {
        return GroupId::fromString(Uuid::uuid4()->toString());
    }
}
